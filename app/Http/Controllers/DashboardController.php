<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Layanan;
use App\Models\Tes;
use App\Models\Realisasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function beranda()
    {
        Carbon::setLocale('id');

        $layanan = Auth::user()->layanan()->with([
            'pengguna' => function($query) {
                $query->where('role', 'pendaftar');
            },
            'topik',
            'narasumber'
        ])->first();

        $pendaftar = $layanan ? $layanan->pengguna->first() : null;
        $pengguna = Auth::user();

        $tes = null;
        if ($layanan) {
            $pivot = $layanan->pengguna()->where('pengguna_id', $pengguna->id)->first();

            if ($pivot && $pivot->pivot->tes_id) {
                $tes = \App\Models\Tes::find($pivot->pivot->tes_id);
            }
        }

        $topikPertama = $layanan && $layanan->topik ? $layanan->topik->first() : null;

        $hariKegiatan = Carbon::now()->diffInDays(Carbon::parse($layanan->tanggal), false);
        $hariNonaktif = Carbon::now()->diffInDays(Carbon::parse($pengguna->expired_at), false);


        return view('peserta.beranda', compact(
            'layanan', 'pengguna', 'pendaftar',
            'hariKegiatan', 'hariNonaktif',
            'topikPertama', 'tes'
        ));
    }

    public function home()
    {
        Carbon::setLocale('id');

        $pengguna = Auth::user();

        $layananList = Layanan::with(['realisasi', 'kategori', 'topik', 'narasumber', 'pengguna'])
            ->whereHas('pengguna', function ($q) use ($pengguna) {
                $q->where('pengguna_id', $pengguna->id);
            })
            ->whereHas('status', function ($q) {
                $q->where('status', 'Disetujui');
            })
            ->get()
            ->map(function ($layanan) use ($pengguna) {
                $pivot = $layanan->pengguna->firstWhere('id', $pengguna->id)?->pivot;
                $tes = $pivot && $pivot->tes_id ? Tes::find($pivot->tes_id) : null;
                $topikPertama = $layanan->topik->first();
                $hariKegiatan = Carbon::now()->diffInDays(Carbon::parse($layanan->tanggal), false);
                $labelHariKegiatan = (int) $hariKegiatan >= 0 ? 'D-' . (int) $hariKegiatan : 'D+' . (int) abs($hariKegiatan);

                $layanan->tes = $tes;
                $layanan->topikPertama = $topikPertama;
                $layanan->hariKegiatan = $hariKegiatan;
                $layanan->labelHariKegiatan = $labelHariKegiatan;

                return $layanan;
            })
            ->sortBy('hariKegiatan');

        return view('layout.home', compact('layananList'));
    }

    public function dashboard()
    {
        $jenisLayanan = Layanan::select('jenis_layanan')->distinct()->get();
        $urutan = ['KIE di BBPOM Padang', 'KIE di luar BBPOM Padang', 'KIETOMAS (Komunikasi Informasi Edukasi Bersama Tokoh Masyarakat)']; // Sesuaikan dengan urutan yang diinginkan
        $jenisLayanan = $jenisLayanan->filter(function ($item) use ($urutan) {
            return in_array($item->jenis_layanan, $urutan);
        })->sortBy(function ($item) use ($urutan) {
            return array_search($item->jenis_layanan, $urutan);
        });

        $data = [];
        $warna = [
            'KIE di luar BBPOM Padang' => [
                'cards' => ['bg-red-200', 'bg-green-200', 'bg-blue-200'],
                'chart' => ['#ef4444', '#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ec4899'],
            ],
            'KIE di BBPOM Padang' => [
                'cards' => ['bg-yellow-200', 'bg-purple-200', 'bg-pink-200'],
                'chart' => ['#facc15', '#a78bfa', '#f472b6', '#60a5fa', '#34d399', '#f87171'],
            ],
            'KIETOMAS (Komunikasi Informasi Edukasi Bersama Tokoh Masyarakat)' => [
                'cards' => ['bg-teal-200', 'bg-indigo-200', 'bg-red-200'],
                'chart' => ['#2dd4bf', '#6366f1', '#06b6d4', '#0ea5e9', '#9333ea', '#f43f5e'],
            ],
        ];

        foreach ($jenisLayanan as $jenis) {
            $totalSeminar = Layanan::where('jenis_layanan', $jenis->jenis_layanan)->count();
            $totalPeserta = Layanan::where('jenis_layanan', $jenis->jenis_layanan)->sum('jumlah_peserta');

            $totalPartisipasi = Realisasi::whereHas('layanan', function ($q) use ($jenis) {
                $q->where('jenis_layanan', $jenis->jenis_layanan);
            })->sum('jumlah_peserta_hadir');

            $persentasePartisipasi = 0;
            if ($totalPeserta > 0) {
                $persentasePartisipasi = ($totalPartisipasi / $totalPeserta) * 100;
            }

            $persentasePartisipasi = min($persentasePartisipasi, 100);

            $kategoriPeserta = DB::table('layanan')
                ->join('kategori', 'layanan.kategori_id', '=', 'kategori.id')
                ->select('kategori.nama as kategori', DB::raw('SUM(layanan.jumlah_peserta) as total'))
                ->where('layanan.jenis_layanan', $jenis->jenis_layanan)
                ->groupBy('kategori.nama')
                ->get();

            $topikPopuler = DB::table('layanan_topik')
                ->join('layanan', 'layanan_topik.layanan_id', '=', 'layanan.layanan_id')
                ->join('topik', 'layanan_topik.topik_id', '=', 'topik.id')
                ->select('topik.judul as topik', DB::raw('COUNT(DISTINCT layanan_topik.layanan_id) as total'))
                ->where('layanan.jenis_layanan', $jenis->jenis_layanan)
                ->groupBy('topik.judul')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            $data[$jenis->jenis_layanan] = [
                'totalSeminar' => $totalSeminar,
                'totalPeserta' => $totalPeserta,
                'persentasePartisipasi' => $persentasePartisipasi,
                'kategoriPeserta' => $kategoriPeserta,
                'topikPopuler' => $topikPopuler,
            ];

            if ($jenis->jenis_layanan == 'KIE di BBPOM Padang') {
                $layananList = Layanan::with(['pengguna' => function ($q) {
                    $q->withPivot('tes_id');
                }])->where('jenis_layanan', $jenis->jenis_layanan)->get();

                $tesList = collect();

                foreach ($layananList as $layanan) {
                    foreach ($layanan->pengguna as $pengguna) {
                        if ($pengguna->pivot && $pengguna->pivot->tes_id) {
                            $tes = Tes::find($pengguna->pivot->tes_id);
                            if ($tes) {
                                $tesList->push($tes);
                            }
                        }
                    }
                }

                $avgPretest = $tesList->pluck('skor_pretest')->filter()->avg();
                $avgPosttest = $tesList->pluck('skor_posttest')->filter()->avg();

                $peningkatan = 0;
                if ($avgPretest > 0) {
                    $peningkatan = (($avgPosttest - $avgPretest) / $avgPretest) * 100;
                }

                $data[$jenis->jenis_layanan]['avgPretest'] = round($avgPretest, 1);
                $data[$jenis->jenis_layanan]['avgPosttest'] = round($avgPosttest, 1);
                $data[$jenis->jenis_layanan]['peningkatan'] = round($peningkatan, 1);
            }
        }
        return view('layout.dashboard', [
            'jenisLayanan' => $jenisLayanan,
            'data' => $data,
            'warna' => $warna
        ]);
    }

}
