<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Topik;
use App\Models\Soal;
use App\Models\Layanan;
use App\Models\Tes;

class TesController extends Controller
{
    public function pretest($layananId, $topikId)
    {
        $layanan = Auth::user()->layanan;

        $topikIds = DB::table('layanan_topik')
            ->where('layanan_id', $layananId)
            ->orderBy('topik_id')
            ->pluck('topik_id')
            ->toArray();

        $topiks = Topik::whereIn('id', $topikIds)
            ->get()
            ->sortBy(function ($topik) use ($topikIds) {
                return array_search($topik->id, $topikIds);
            })
            ->values();

        $topik = $topiks->firstWhere('id', $topikId);

        if (!$topik) {
            return redirect()->back()->with('error', 'Topik tidak ditemukan.');
        }

        $soals = Soal::where('topik_id', $topik->id)
                ->inRandomOrder()
                ->limit(10)
                ->get();


        $currentIndex = $topiks->search(fn ($t) => (int) $t->id === (int) $topikId);

        if ($currentIndex === false) {
            return redirect()->back()->with('error', 'Topik tidak ditemukan.');
        }

        $isLastTopik = ($currentIndex === $topiks->count() - 1);

        return view('peserta.pre-test', compact('topik', 'soals', 'layananId', 'isLastTopik', 'topikId'));
    }

    public function nextTopik(Request $request, $layananId, $topikId)
    {
        $jawaban = $request->input('jawaban', []);
        $existing = session()->get('pretest_jawaban', []);
        $merged = array_replace($existing, $jawaban);
        session()->put('pretest_jawaban', $merged);

        $topikIds = DB::table('layanan_topik')
            ->where('layanan_id', $layananId)
            ->orderBy('topik_id')
            ->pluck('topik_id')
            ->toArray();

        $topiks = Topik::whereIn('id', $topikIds)
            ->get()
            ->sortBy(fn($t) => array_search($t->id, $topikIds))
            ->values();

        $currentIndex = $topiks->search(fn ($t) => $t->id == $topikId);
        $nextTopik = $topiks->get($currentIndex + 1);

        if ($nextTopik) {
            return redirect()->route('pretest.index', [$layananId, $nextTopik->id]);
        }

        return redirect()->route('pretest.submit', [$layananId]);
    }

    public function submit(Request $request, $layananId)
    {
        $user = Auth::user();

        $jawabanSebelumnya = session('pretest_jawaban', []);
        $jawabanBaru = $request->input('jawaban');
        $gabunganJawaban = $jawabanSebelumnya + $jawabanBaru;
        session(['pretest_jawaban' => $gabunganJawaban]);

        $topikIds = DB::table('layanan_topik')
            ->where('layanan_id', $layananId)
            ->pluck('topik_id')
            ->toArray();;

        $jawabanPeserta = session('pretest_jawaban', []);
        $soalIds = array_keys($jawabanPeserta);
        $soals = Soal::whereIn('id', $soalIds)->get();

        $jumlahBenar = 0;

        foreach ($soals as $soal) {
            if (isset($jawabanPeserta[$soal->id]) && $jawabanPeserta[$soal->id] === $soal->opsi_benar) {
                $jumlahBenar++;
            }
        }

        $totalSoal = $soals->count();
        $skor = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100) : 0;

        $layananPengguna = DB::table('layanan_pengguna')
            ->where('layanan_id', $layananId)
            ->where('pengguna_id', $user->id)
            ->first();


        if ($layananPengguna) {
            $tes = DB::table('tes')->insertGetId([
                'skor_pretest' => $skor,
            ]);

            DB::table('layanan_pengguna')
            ->where('layanan_id', $layananId)
            ->where('pengguna_id', $user->id)
            ->update(['tes_id' => $tes]);
        } else {

            return redirect()->route('peserta.dashboard')->with('error', 'Hubungan antara pengguna dan layanan tidak ditemukan.');
        }

        session()->forget('pretest_jawaban');

        return redirect()->route('peserta.dashboard')->with('success', 'Pre-test selesai. Skor: ' . $skor);
    }

    public function posttest($layananId, $topikId)
    {
        $layanan = Auth::user()->layanan;

        $topikIds = DB::table('layanan_topik')
            ->where('layanan_id', $layananId)
            ->orderBy('topik_id')
            ->pluck('topik_id')
            ->toArray();

        $topiks = Topik::whereIn('id', $topikIds)
            ->get()
            ->sortBy(function ($topik) use ($topikIds) {
                return array_search($topik->id, $topikIds);
            })
            ->values();

        $topik = $topiks->firstWhere('id', $topikId);

        if (!$topik) {
            return redirect()->back()->with('error', 'Topik tidak ditemukan.');
        }

        $soals = Soal::where('topik_id', $topik->id)
                    ->inRandomOrder()
                    ->limit(10)
                    ->get();


        $currentIndex = $topiks->search(fn ($t) => (int) $t->id === (int) $topikId);

        if ($currentIndex === false) {
            return redirect()->back()->with('error', 'Topik tidak ditemukan.');
        }

        $isLastTopik = ($currentIndex === $topiks->count() - 1);

        return view('peserta.post-test', compact('topik', 'soals', 'layananId', 'isLastTopik', 'topikId'));
    }

    public function nextopik(Request $request, $layananId, $topikId)
    {
        $jawaban = $request->input('jawaban', []);
        $existing = session()->get('posttest_jawaban', []);
        $merged = array_replace($existing, $jawaban);
        session()->put('posttest_jawaban', $merged);

        $topikIds = DB::table('layanan_topik')
            ->where('layanan_id', $layananId)
            ->orderBy('topik_id')
            ->pluck('topik_id')
            ->toArray();

        $topiks = Topik::whereIn('id', $topikIds)
            ->get()
            ->sortBy(fn($t) => array_search($t->id, $topikIds))
            ->values();

        $currentIndex = $topiks->search(fn ($t) => $t->id == $topikId);
        $nextTopik = $topiks->get($currentIndex + 1);

        if ($nextTopik) {
            return redirect()->route('posttest.index', [$layananId, $nextTopik->id]);
        }

        return redirect()->route('posttest.submit', [$layananId]);
    }

    public function submitPosttest(Request $request, $layananId)
    {
        $user = Auth::user();

        $jawabanSebelumnya = session('posttest_jawaban', []);
        $jawabanBaru = $request->input('jawaban');
        $gabunganJawaban = $jawabanSebelumnya + $jawabanBaru;
        session(['posttest_jawaban' => $gabunganJawaban]);

        $topikIds = DB::table('layanan_topik')
            ->where('layanan_id', $layananId)
            ->pluck('topik_id')
            ->toArray();

        $jawabanPeserta = session('posttest_jawaban', []);
        $soalIds = array_keys($jawabanPeserta);
        $soals = Soal::whereIn('id', $soalIds)->get();

        $jumlahBenar = 0;

        foreach ($soals as $soal) {
            if (isset($jawabanPeserta[$soal->id]) && $jawabanPeserta[$soal->id] === $soal->opsi_benar) {
                $jumlahBenar++;
            }
        }

        $totalSoal = $soals->count();
        $skor = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100) : 0;

        $layananPengguna = DB::table('layanan_pengguna')
            ->where('layanan_id', $layananId)
            ->where('pengguna_id', $user->id)
            ->first();

        if ($layananPengguna && $layananPengguna->tes_id) {
            $tes = DB::table('tes')->where('id', $layananPengguna->tes_id)->first();

            $skorSebelumnya = $tes->skor_posttest;

            DB::table('tes')->where('id', $layananPengguna->tes_id)
                ->update(['skor_posttest' => $skor]);

            session()->forget('posttest_jawaban');

            if (is_null($skorSebelumnya)) {
                return redirect()->route('peserta.dashboard')->with('showSurveyModal', true);
            }

            return redirect()->route('peserta.dashboard')->with('success', 'Post-test selesai. Skor: ' . $skor);
        }

        return redirect()->route('peserta.dashboard')->with('error', 'Data tes belum tersedia.');
    }

    public function submitSurvey(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::user();

        $layananPengguna = DB::table('layanan_pengguna')
            ->where('pengguna_id', $user->id)
            ->first();

        if ($layananPengguna && $layananPengguna->tes_id) {
            DB::table('tes')->where('id', $layananPengguna->tes_id)
                ->update(['rating' => $request->rating]);

            $layanan = DB::table('layanan')
                        ->where('layanan_id', $layananPengguna->layanan_id)
                        ->first();

            $link = $layanan->link_survey ?? '/';

            return redirect()
                ->route('peserta.dashboard')
                ->with(['show_survey_modal' => true, 'link_survey' => $link]);
        }

        return redirect()->route('peserta.dashboard')->with('error', 'Gagal menyimpan survei.');
    }

    public function generate($layananId)
    {
        Carbon::setLocale('id');

        $pengguna = auth()->user();

        $layanan = Layanan::with('topik')->findOrFail($layananId);

        $pdf = Pdf::loadView('pdf.sertifikat', compact('layanan', 'pengguna'))
                ->setPaper('A4', 'landscape');

        return $pdf->download('sertifikat-' . $pengguna->nama . '.pdf');
    }



    // Untuk Pendaftar

    public function pre_test($layananId, $topikId)
    {
        $layanan = Auth::user()->layanan;

        $topikIds = DB::table('layanan_topik')
            ->where('layanan_id', $layananId)
            ->orderBy('topik_id')
            ->pluck('topik_id')
            ->toArray();

        $topiks = Topik::whereIn('id', $topikIds)
            ->get()
            ->sortBy(function ($topik) use ($topikIds) {
                return array_search($topik->id, $topikIds);
            })
            ->values();

        $topik = $topiks->firstWhere('id', $topikId);

        if (!$topik) {
            return redirect()->back()->with('error', 'Topik tidak ditemukan.');
        }

        $soals = Soal::where('topik_id', $topik->id)
                ->inRandomOrder()
                ->limit(10)
                ->get();


        $currentIndex = $topiks->search(fn ($t) => $t->id == $topikId);
        $isLastTopik = ($currentIndex === $topiks->count() - 1);

        return view('pendaftar.pretest', compact('topik', 'soals', 'layananId', 'isLastTopik', 'topikId'));
    }

    public function selanjutnya(Request $request, $layananId, $topikId)
    {
        $jawaban = $request->input('jawaban', []);
        $existing = session()->get('pretest_jawaban', []);
        $merged = array_replace($existing, $jawaban);
        session()->put('pretest_jawaban', $merged);

        $topikIds = DB::table('layanan_topik')
            ->where('layanan_id', $layananId)
            ->orderBy('topik_id')
            ->pluck('topik_id')
            ->toArray();

        $topiks = Topik::whereIn('id', $topikIds)
            ->get()
            ->sortBy(fn($t) => array_search($t->id, $topikIds))
            ->values();

        $currentIndex = $topiks->search(fn ($t) => $t->id == $topikId);
        $nextTopik = $topiks->get($currentIndex + 1);

        if ($nextTopik) {
            return redirect()->route('pendaftar.pretest', [$layananId, $nextTopik->id]);
        }

        return redirect()->route('pendaftar.submit', [$layananId]);
    }

    public function kirim(Request $request, $layananId)
    {
        $user = Auth::user();

        $jawabanSebelumnya = session('pretest_jawaban', []);
        $jawabanBaru = $request->input('jawaban');
        $gabunganJawaban = $jawabanSebelumnya + $jawabanBaru;
        session(['pretest_jawaban' => $gabunganJawaban]);

        $topikIds = DB::table('layanan_topik')
            ->where('layanan_id', $layananId)
            ->pluck('topik_id')
            ->toArray();;

        $jawabanPeserta = session('pretest_jawaban', []);
        $soalIds = array_keys($jawabanPeserta);
        $soals = Soal::whereIn('id', $soalIds)->get();

        $jumlahBenar = 0;

        foreach ($soals as $soal) {
            if (isset($jawabanPeserta[$soal->id]) && $jawabanPeserta[$soal->id] === $soal->opsi_benar) {
                $jumlahBenar++;
            }
        }

        $totalSoal = $soals->count();
        $skor = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100) : 0;

        $layananPengguna = DB::table('layanan_pengguna')
            ->where('layanan_id', $layananId)
            ->where('pengguna_id', $user->id)
            ->first();


        if ($layananPengguna) {
            $tes = DB::table('tes')->insertGetId([
                'skor_pretest' => $skor,
            ]);

            DB::table('layanan_pengguna')
            ->where('layanan_id', $layananId)
            ->where('pengguna_id', $user->id)
            ->update(['tes_id' => $tes]);
        } else {

            return redirect()->route('pendaftar.dashboard')->with('error', 'Hubungan antara pengguna dan layanan tidak ditemukan.');
        }

        session()->forget('pretest_jawaban');

        return redirect()->route('pendaftar.dashboard')->with('success', 'Pre-test selesai. Skor: ' . $skor);
    }

    public function postest($layananId, $topikId)
    {
        $layanan = Auth::user()->layanan;

        $topikIds = DB::table('layanan_topik')
            ->where('layanan_id', $layananId)
            ->orderBy('topik_id')
            ->pluck('topik_id')
            ->toArray();

        $topiks = Topik::whereIn('id', $topikIds)
            ->get()
            ->sortBy(function ($topik) use ($topikIds) {
                return array_search($topik->id, $topikIds);
            })
            ->values();

        $topik = $topiks->firstWhere('id', $topikId);

        if (!$topik) {
            return redirect()->back()->with('error', 'Topik tidak ditemukan.');
        }

        $soals = Soal::where('topik_id', $topik->id)
                    ->inRandomOrder()
                    ->limit(10)
                    ->get();


        $currentIndex = $topiks->search(fn ($t) => $t->id == $topikId);
        $isLastTopik = ($currentIndex === $topiks->count() - 1);

        return view('pendaftar.postest', compact('topik', 'soals', 'layananId', 'isLastTopik', 'topikId'));
    }

    public function topiknext(Request $request, $layananId, $topikId)
    {
        $jawaban = $request->input('jawaban', []);
        $existing = session()->get('posttest_jawaban', []);
        $merged = array_replace($existing, $jawaban);
        session()->put('posttest_jawaban', $merged);

        $topikIds = DB::table('layanan_topik')
            ->where('layanan_id', $layananId)
            ->orderBy('topik_id')
            ->pluck('topik_id')
            ->toArray();

        $topiks = Topik::whereIn('id', $topikIds)
            ->get()
            ->sortBy(fn($t) => array_search($t->id, $topikIds))
            ->values();

        $currentIndex = $topiks->search(fn ($t) => $t->id == $topikId);
        $nextTopik = $topiks->get($currentIndex + 1);

        if ($nextTopik) {
            return redirect()->route('pendaftar.postest', [$layananId, $nextTopik->id]);
        }

        return redirect()->route('pendaftar.kirim', [$layananId]);
    }

    public function kirimtes(Request $request, $layananId)
    {
        $user = Auth::user();

        $jawabanSebelumnya = session('posttest_jawaban', []);
        $jawabanBaru = $request->input('jawaban');
        $gabunganJawaban = $jawabanSebelumnya + $jawabanBaru;
        session(['posttest_jawaban' => $gabunganJawaban]);

        $topikIds = DB::table('layanan_topik')
            ->where('layanan_id', $layananId)
            ->pluck('topik_id')
            ->toArray();

        $jawabanPeserta = session('posttest_jawaban', []);
        $soalIds = array_keys($jawabanPeserta);
        $soals = Soal::whereIn('id', $soalIds)->get();

        $jumlahBenar = 0;

        foreach ($soals as $soal) {
            if (isset($jawabanPeserta[$soal->id]) && $jawabanPeserta[$soal->id] === $soal->opsi_benar) {
                $jumlahBenar++;
            }
        }

        $totalSoal = $soals->count();
        $skor = $totalSoal > 0 ? round(($jumlahBenar / $totalSoal) * 100) : 0;

        $layananPengguna = DB::table('layanan_pengguna')
            ->where('layanan_id', $layananId)
            ->where('pengguna_id', $user->id)
            ->first();

        if ($layananPengguna && $layananPengguna->tes_id) {
            $tes = DB::table('tes')->where('id', $layananPengguna->tes_id)->first();

            $skorSebelumnya = $tes->skor_posttest;

            DB::table('tes')->where('id', $layananPengguna->tes_id)
                ->update(['skor_posttest' => $skor]);

            session()->forget('posttest_jawaban');

            if (is_null($skorSebelumnya)) {
                return redirect()->route('peserta.dashboard')->with('showSurveyModal', true);
            }

            return redirect()->route('pendaftar.dashboard')->with('success', 'Post-test selesai. Skor: ' . $skor);
        }

        return redirect()->route('pendaftar.dashboard')->with('error', 'Data tes belum tersedia.');
    }

    public function submitrating(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::user();

        $layananPengguna = DB::table('layanan_pengguna')
            ->where('pengguna_id', $user->id)
            ->first();

        if ($layananPengguna && $layananPengguna->tes_id) {
            DB::table('tes')->where('id', $layananPengguna->tes_id)
                ->update(['rating' => $request->rating]);

            $layanan = DB::table('layanan')
                        ->where('layanan_id', $layananPengguna->layanan_id)
                        ->first();

            $link = $layanan->link_survey ?? '/';

           return redirect()
                ->route('pendaftar.dashboard')
                ->with(['show_survey_modal' => true, 'link_survey' => $link]);
        }

        return redirect()->route('pendaftar.dashboard')->with('error', 'Gagal menyimpan survei.');
    }

}
