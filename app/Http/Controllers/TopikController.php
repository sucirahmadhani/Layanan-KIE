<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Topik;
use App\Models\Soal;
use Illuminate\Support\Facades\DB;

class TopikController extends Controller
{
    public function index()
    {
        $topiks = Topik::all();
        return view('layout.topik', compact('topiks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'tahun' => 'required|digits:4',
        ]);

        Topik::create($request->all());
        return redirect()->back()->with('success', 'Topik berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $topik = Topik::findOrFail($id);
        $topik->delete();

        return redirect()->route('topik.index')->with('success', 'Topik berhasil dihapus');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tahun' => 'required|integer',
        ]);

        $topik = Topik::findOrFail($id);
        $topik->judul = $request->judul;
        $topik->tahun = $request->tahun;
        $topik->save();

        return redirect()->route('topik.index')->with('success', 'Topik berhasil diperbarui');
    }

    public function soal(Topik $topik)
    {
        $soals = Soal::where('topik_id', $topik->id)
                 ->orderByDesc('tampilkan')
                 ->get();

        foreach ($soals as $soal) {
            $soal->opsi = json_decode($soal->opsi_salah, true);
        }

        return view('admin.soal', compact('soals', 'topik'));
    }

    public function soal_create(Topik $topik)
    {
        return view('admin.tambah-soal', compact('topik'));
    }

    public function soal_store(Request $request, Topik $topik)
    {
        $soalTampilkanCount = Soal::where('topik_id', $topik->id)
                              ->where('tampilkan', true)
                              ->count();

        if ($soalTampilkanCount >= 10) {
            return redirect()->route('soal.show', $topik->id)
                            ->with('error', 'Jumlah soal yang tampilkan sudah mencapai batas maksimum (10 soal).');
        }

        $request->validate([
            'soal.*.pertanyaan' => 'required|string',
            'soal.*.opsi_benar' => 'required|string',
            'soal.*.opsi_salah' => 'required|array|min:3',
            'soal.*.opsi_salah.*' => 'required|string',
            'soal.*.tampilkan' => 'required|boolean',
        ]);

        foreach ($request->soal as $item) {
            Soal::create([
                'topik_id' => $topik->id,
                'pertanyaan' => $item['pertanyaan'],
                'opsi_benar' => $item['opsi_benar'],
                'opsi_salah' => json_encode($item['opsi_salah']),
                'tampilkan' => $item['tampilkan'],
            ]);

        }

        return redirect()->route('soal.show',  $topik)->with('success', 'Soal berhasil ditambahkan!');
    }

    public function soal_destroy($id)
    {
        $soal = Soal::findOrFail($id);
        $soal->delete();

        return redirect()->route('soal.show', $soal->topik_id)->with('success', 'Topik berhasil dihapus');
    }

    public function soal_edit(Soal $soal)
    {
        $soal->opsi_salah = json_decode($soal->opsi_salah);

        return view('admin.edit-soal', compact('soal'));
    }

    public function soal_update(Request $request, Soal $soal)
    {

        if ($request->input('tampilkan') == true) {
            $soalTampilkanCount = Soal::where('topik_id', $soal->topik_id)
                                      ->where('tampilkan', true)
                                      ->count();

            if ($soalTampilkanCount >= 10 && $soal->tampilkan != true) {
                return redirect()->route('soal.show', $soal->topik_id)
                                 ->with('error', 'Jumlah soal yang tampilkan sudah mencapai batas maksimum (10 soal).');
            }
        }

        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'opsi_benar' => 'required|string',
            'opsi_salah' => 'required|array|min:3',
            'opsi_salah.*' => 'required|string',
            'tampilkan' => 'required|boolean',
        ]);

        $soal->update([
            'pertanyaan' => $validated['pertanyaan'],
            'opsi_benar' => $validated['opsi_benar'],
            'opsi_salah' => json_encode($validated['opsi_salah']),
            'tampilkan' => $validated['tampilkan'],
        ]);

        return redirect()->route('soal.show', $soal->topik_id)->with('success', 'Soal berhasil diperbarui!');
    }

}
