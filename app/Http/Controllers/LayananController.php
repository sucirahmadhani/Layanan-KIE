<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\Fonnte;
use App\Models\Pengguna;
use App\Models\Kategori;
use App\Models\Topik;
use App\Models\Layanan;
use App\Models\Narasumber;
use App\Models\Status;
use App\Models\Realisasi;
use App\Models\Tes;



class LayananController extends Controller
{

    public function daftar()
    {
        $kategori = Kategori::all();
        $topik = Topik::all();

        return view('layout.daftar', compact('kategori', 'topik'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_layanan' => 'required|string',
            'nama_instansi' => 'required|string|max:100',
            'kategori_id' => 'required|exists:kategori,id',
            'tempat' => 'required|string|max:50',
            'waktu' => 'required|string|max:10',
            'jumlah_peserta' => 'required|integer|min:1',
            'minggu' => 'required|integer|between:1,4',
            'bulan' => 'required|string|max:10',
            'surat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'topik' => 'required|array',
            'topik.*' => 'exists:topik,id',
            'opsi_tanggal' => 'string',
        ]);

        $suratFile = $request->file('surat');
        $suratPath = $suratFile->storeAs('surat_layanan', $suratFile->getClientOriginalName(), 'public');


        $layanan = Layanan::create([
            'layanan_id' => Layanan::generateLayananId(),
            'narasumber_id' => null,
            'kategori_id' => $request->kategori_id,
            'tanggal' => null,
            'tempat' => $request->tempat,
            'waktu' => $request->waktu,
            'jumlah_peserta' => $request->jumlah_peserta,
            'surat' => $suratFile->getClientOriginalName(),
            'nama_instansi' => $request->nama_instansi,
            'jenis_layanan' => $request->jenis_layanan,
            'minggu' => $request->minggu,
            'bulan' => $request->bulan,
            'opsi_tanggal' => $request->opsi_tanggal,
        ]);

        Status::create([
            'layanan_id' => $layanan->layanan_id,
            'status' => 'Menunggu Konfirmasi',
            'catatan' => null,
        ]);

        $layanan->topik()->attach($request->topik);

        $pengguna = Auth::user();

        if (!$pengguna) {
            return redirect()->back()->withErrors(['error' => 'Pengguna tidak ditemukan']);
        }

        $layanan->pengguna()->attach($pengguna->id);

        $admin = Pengguna::where('role', 'admin')->first();

        if ($admin && $admin->phone_number) {
            $message = "📢 Pendaftaran Layanan Baru\n\n" .
                    "🧾 Instansi: {$request->nama_instansi}\n" .
                    "📌 Jenis Layanan: {$request->jenis_layanan}\n" .
                    "📍 Tempat: {$request->tempat}\n" .
                    "🕒 Waktu: {$request->waktu}\n\n" .
                    "Silakan login ke sistem untuk konfirmasi.";

            Fonnte::sendWA($admin->phone_number, $message);
        }

        return redirect()->route('proses.show')->with('success', 'Pendaftaran layanan berhasil, menunggu konfirmasi Balai Besar POM di Padang.');
    }

    public function proses()
    {
        Carbon::setLocale('id');

        $pengguna = Auth::user();

        if (!$pengguna) {
            return redirect('/login')->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }

        $layanan = Layanan::whereHas('pengguna', function ($query) use ($pengguna) {
                        $query->where('pengguna.id', $pengguna->id);
                    })
                    ->whereHas('status', function ($query) {
                        $query->where('status', '!=', 'Selesai');
                    })
                    ->with(['kategori', 'topik', 'status',
                    'pengguna' => function ($query) {
                        $query->select('pengguna.id', 'nama', 'username', 'email'); }
                    ])
                    ->orderBy('created_at', 'desc')->get();

        return view('layout.proses', compact('layanan'));
    }

    public function permintaan()
    {
        $layanan = Layanan::whereHas('status', function ($query) {
            $query->where('status', '!=', 'Selesai');
        })->orderBy('created_at', 'desc')->get();

        return view('layout.permintaan', compact('layanan'));

    }

    public function edit($id)
    {
        Carbon::setLocale('id');
        $layanan = Layanan::with(['status', 'kategori', 'topik'])->findOrFail($id);
        $narasumber = Narasumber::all();

        return view('layout.editpermintaan', compact('layanan', 'narasumber'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'status' => 'required|string',
            'link_survey' => 'nullable|string',
            'link_absence' => 'nullable|string',
            'catatan' => 'nullable|string',
        ];

        if ($request->status === 'Disetujui') {
            $rules['tanggal'] = 'required|date';
            $rules['narasumber_id'] = 'required|exists:narasumber,narasumber_id';
        } else {
            $rules['tanggal'] = 'nullable|date';
            $rules['narasumber_id'] = 'nullable|exists:narasumber,narasumber_id';
        }

        $validatedData = $request->validate($rules);

        $layanan = Layanan::where('layanan_id', $id)->firstOrFail();
        $layanan->tanggal = $validatedData['tanggal'] ?? null;
        $layanan->narasumber_id = $validatedData['narasumber_id'] ?? null;
        $layanan->link_survey = $validatedData['link_survey'] ?? null;
        $layanan->link_absence = $validatedData['link_absence'] ?? null;
        $layanan->save();

        $status = Status::updateOrCreate(
            ['layanan_id' => $layanan->layanan_id],
            [
                'status' => $request->status,
                'catatan' => $request->catatan,
            ]
        );

        $pendaftar = $layanan->pengguna()->where('role', 'pendaftar')->first();

        if ($pendaftar && $pendaftar->phone_number) {
            $message = "📢 Pendaftaran layanan KIE anda telah dikonfirmasi oleh Balai Besar POM di Padang\n\n" .
                       "Silakan login ke sistem untuk melihat detail.";

            Fonnte::sendWA($pendaftar->phone_number, $message);
        }

        if ($request->status === 'Menunggu Konfirmasi') {
            return redirect()->route('layanan.edit', $id)
                             ->with('info', 'Mohon konfirmasi layanan ini.');
        }

        return redirect()->route('layanan.permintaan')->with('success', 'Permintaan berhasil dikonfirmasi.');
    }

    public function selesai($id)
    {
        $status = Status::where('layanan_id', $id)->first();

        if ($status) {
            $status->update(['status' => 'Selesai']);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Status tidak ditemukan.'], 404);
    }


    public function destroy($id)
    {
        $layanan = Layanan::where('layanan_id', $id)->firstOrFail();

        $layanan->status()->delete();
        $layanan->delete();

        return redirect()->route('layanan.permintaan')->with('success', 'Layanan berhasil dihapus.');
    }

    public function generateAkun(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'layanan_id' => 'required|exists:layanan,layanan_id',
        ]);

        $jumlah = $request->jumlah;
        $layanan_id = $request->layanan_id;
        $akunData = [];

        $layanan = Layanan::findOrFail($layanan_id);
        $tanggalLayanan = $layanan->tanggal;
        $expired_at = \Carbon\Carbon::parse($tanggalLayanan)->addMonths(2);

        for ($i = 0; $i < $jumlah; $i++) {
            $username = 'user' . now()->timestamp . $i;
            $password = 'pass' . rand(1000, 9999);
            $email = 'user' . now()->timestamp . $i . '@example.com';

            $peserta = Pengguna::create([
                'nama' => 'Peserta ' . ($i + 1),
                'username' => $username,
                'email' => $email,
                'password' => bcrypt($password),
                'role' => 'peserta',
                'expired_at' => $expired_at,
            ]);

            $peserta->layanan()->attach($layanan_id);

            $akunData[] = [
                'nama' => $peserta->nama,
                'username' => $username,
                'password' => $password,
                'email' => $email,
            ];
        }

        $pdf = Pdf::loadView('pdf.akun', ['akunData' => $akunData]);

        return $pdf->download('akun.pdf')
            ->header('Location', route('proses.show', ['id' => $layanan_id]));
    }

    public function realisasi()
    {
        Carbon::setLocale('id');
        $layanan = Layanan::whereHas('status', function ($query) {
            $query->where('status', 'Selesai');
        })->orderBy('created_at', 'desc')->get();

        return view('pendaftar.realisasi', compact('layanan'));
    }

    public function realisasi_show($id)
    {
        Carbon::setLocale('id');

        $layanan = Layanan::with([
            'realisasi',
            'kategori',
            'topik',
            'narasumber',
            'pengguna' => function ($query) {
                $query->withPivot('tes_id');
            }
        ])->findOrFail($id);

        $averageRating = null;
        $averagePretest = null;
        $averagePosttest = null;

        if ($layanan->jenis_layanan === 'KIE di BBPOM Padang' && $layanan->relationLoaded('pengguna')) {
            $tesList = $layanan->pengguna->map(function ($pengguna) {
                return Tes::find($pengguna->pivot->tes_id);
            })->filter();

            $ratings = $tesList->pluck('rating')->filter();
            $averageRating = $ratings->count() ? round($ratings->avg(), 1) : null;

            $pretests = $tesList->pluck('skor_pretest')->filter();
            $averagePretest = $pretests->count() ? round($pretests->avg(), 1) : null;

            $posttests = $tesList->pluck('skor_posttest')->filter();
            $averagePosttest = $posttests->count() ? round($posttests->avg(), 1) : null;
        }

        return view('pendaftar.detail_realisasi', compact('layanan', 'averageRating', 'averagePretest', 'averagePosttest'));
    }

    public function realisasi_edit($id)
    {
        Carbon::setLocale('id');
        $layanan = Layanan::with(['narasumber', 'realisasi'])->findOrFail($id);

        return view('pendaftar.edit-realisasi', compact('layanan'));
    }

    public function realisasi_store(Request $request, $id)
    {
        $request->validate([
            'jumlah_peserta' => 'nullable|integer',
            'tempat' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'waktu' => 'nullable|date_format:H:i',
            'narasumber' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'laporan' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'catatan' => 'nullable|string',
        ]);

        $fotoPath = null;
        $laporanPath = null;

        if ($request->hasFile('foto')) {
            $originalFotoName = $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('uploads/foto_realisasi', $originalFotoName, 'public');
            $fotoName = $originalFotoName;
        }

        if ($request->hasFile('laporan')) {
            $originalLaporanName = $request->file('laporan')->getClientOriginalName();
            $request->file('laporan')->storeAs('uploads/laporan_realisasi', $originalLaporanName, 'public');
            $laporanName = $originalLaporanName;
        }

        $realisasi = Realisasi::where('layanan_id', $id)->first();

        if ($realisasi) {
            $realisasi->update([
                'jumlah_peserta_hadir' => $request->jumlah_peserta,
                'tempat_realisasi' => $request->tempat,
                'tanggal_realisasi' => $request->tanggal,
                'waktu_realisasi' => $request->waktu,
                'narasumber' => $request->narasumber,
                'foto' => $fotoName ?? $realisasi->foto,
                'laporan' => $laporanName ?? $realisasi->laporan,
                'catatan' => $request->catatan,
            ]);
        } else {
            Realisasi::create([
                'layanan_id' => $id,
                'jumlah_peserta_hadir' => $request->jumlah_peserta,
                'tempat_realisasi' => $request->tempat,
                'tanggal_realisasi' => $request->tanggal,
                'waktu_realisasi' => $request->waktu,
                'narasumber' => $request->narasumber,
                'foto' => $fotoPath,
                'laporan' => $laporanPath,
                'catatan' => $request->catatan,
            ]);
        }

        return redirect()->route('realisasi.show', $id)->with('success', 'Realisasi berhasil disimpan');
    }

    public function  riwayat()
    {
        Carbon::setLocale('id');
        $pengguna = Auth::user();

        $layanan = Layanan::whereHas('pengguna', function ($query) use ($pengguna) {
            $query->where('pengguna.id', $pengguna->id);
        })
        ->whereHas('status', function ($query) {
            $query->where('status', 'Selesai');
        })
        ->orderBy('tanggal', 'desc')->get();

        return view('pendaftar.riwayat', compact('layanan'));
    }

    public function detail_riwayat($id)
    {
        Carbon::setLocale('id');

        $layanan = Layanan::with(['realisasi', 'kategori', 'topik', 'narasumber'])->findOrFail($id);

        $pengguna = Auth::user();

        $pivot = $layanan->pengguna()->where('pengguna_id', $pengguna->id)->first()?->pivot;

        $tes = null;
        if ($pivot && $pivot->tes_id) {
            $tes = Tes::find($pivot->tes_id);
        }

        return view('pendaftar.detail_riwayat', compact('layanan', 'tes'));
    }

}





