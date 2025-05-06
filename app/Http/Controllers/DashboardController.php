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
            $totalSeminar = Layanan::count();
            $totalPeserta = Layanan::sum('jumlah_peserta');
            $totalPartisipasi = Realisasi::sum('jumlah_peserta_hadir');

            $kategoriPeserta = DB::table('layanan')
            ->join('kategori', 'layanan.kategori_id', '=', 'kategori.id')
            ->select('kategori.nama as kategori', DB::raw('SUM(layanan.jumlah_peserta) as total'))
            ->groupBy('kategori.nama')
            ->get();

            $topikPopuler = DB::table('layanan_topik')
            ->join('topik', 'layanan_topik.topik_id', '=', 'topik.id')
            ->select('topik.judul as topik', DB::raw('COUNT(DISTINCT layanan_topik.layanan_id) as total'))
            ->groupBy('topik.judul')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

            return view('layout.dashboard', compact('totalSeminar', 'totalPeserta', 'totalPartisipasi', 'kategoriPeserta', 'topikPopuler'));
        }


}
