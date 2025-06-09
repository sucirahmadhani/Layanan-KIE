<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Narasumber;

class NarasumberController extends Controller
{
    public function index()
    {
        $narasumber = Narasumber::all();
        return view('layout.narasumber', compact('narasumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'instansi' => 'required',
            'jabatan' => 'required',
            'email',
            'no_hp',
            'keahlian' => 'required',
        ]);

        Narasumber::create([
            'narasumber_id' => Narasumber::generateNarasumberId(),
            'nama_narasumber' => $request->nama,
            'instansi' => $request->instansi,
            'jabatan' => $request->jabatan,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'keahlian' => $request->keahlian,
        ]);

        return redirect()->route('narasumber.index')->with('success', 'Narasumber berhasil ditambahkan.');
    }

    public function destroy($narasumber_id)
    {
        $narasumber = Narasumber::findOrFail($narasumber_id);
        $narasumber->delete();

        return redirect()->route('narasumber.index')->with('success', 'Topik berhasil dihapus');
    }

    public function update(Request $request, $narasumber_id)
    {
        $request->validate([
            'nama' => 'required',
            'instansi' => 'required',
            'jabatan' => 'required',
            'email',
            'no_hp',
            'keahlian' => 'required',
        ]);

        $narasumber = Narasumber::findOrFail($narasumber_id);
        $narasumber->nama_narasumber = $request->nama;
        $narasumber->instansi = $request->instansi;
        $narasumber->jabatan = $request->jabatan;
        $narasumber->email = $request->email;
        $narasumber->no_hp = $request->no_hp;
        $narasumber->keahlian = $request->keahlian;
        $narasumber->save();

        return redirect()->route('narasumber.index')->with('success', 'narasumber berhasil diperbarui');
    }
}
