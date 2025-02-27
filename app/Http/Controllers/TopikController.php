<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topik;

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

}
