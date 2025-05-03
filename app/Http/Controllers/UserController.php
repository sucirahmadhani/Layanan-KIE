<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Layanan;

class UserController extends Controller
{
    public function edit()
    {
        $pengguna = Auth::user();

        if (!$pengguna) {
            return redirect('/login')->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }

        if ($pengguna->role === 'admin') {
            return view('layout.editprofil', compact('pengguna'));
        }

        return redirect('/login')->withErrors(['error' => 'Akses tidak diizinkan']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'username' => 'required|string|max:255',
        ]);

        $pengguna = Auth::user();

        if (!$pengguna) {
            return redirect('/login')->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }

        // Cek apakah pengguna adalah pendaftar
        if ($pengguna->role !== 'pendaftar') {
            return redirect('/login')->withErrors(['error' => 'Akses tidak diizinkan']);
        }

        $pengguna->Pengguna::update([
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        $pengguna = Auth::user();

        if (!$pengguna || !Hash::check($request->password_lama, $pengguna->password)) {
            return redirect()->back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
        }

        $pengguna->password = Hash::make($request->password_baru);
        $pengguna->Pengguna::save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }

    public function index()
    {
        $pengguna = Auth::user();

        if ($pengguna->role === 'pendaftar') {
            return view('layout.edit-profil', compact('pengguna'));
        }

        return redirect('/login')->withErrors(['error' => 'Akses tidak diizinkan']);
        
    }

    public function profile()
    {
        $pengguna = Auth::user();

        if (!$pengguna) {
            return redirect('/login')->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }

        if ($pengguna->role !== 'peserta') {
            return redirect('/login')->withErrors(['error' => 'Akses tidak diizinkan']);
        }   

        // $layanan = $pengguna->layanan->first();

        // if (!$layanan) {
        //     return redirect()->back()->with('error', 'Layanan tidak ditemukan.');
        // }

        // // Load topik yang terkait dengan layanan
        // $layanan = Layanan::with(['narasumber', 'topik'])->findOrFail($layanan->id);

        // // Ambil semua topik dari layanan
        // $topiks = $layanan->topik;

        return view('peserta.profile', compact('pengguna'));
    }


    public function updateProfile(Request $request)
    {
        
        $pengguna = Auth::user();

        $pengguna->nama = $request->nama;
        $pengguna->username = $request->username;
        $pengguna->email = $request->email;
        $pengguna->password = Hash::make($request->new_password);

        if ($pengguna->role === 'peserta') {
            $pengguna->profile_updated = true;
        }

        /** @var \App\Models\Pengguna $pengguna */
        $pengguna->save();

        if ($pengguna->role === 'peserta') {
            return redirect()->route('peserta.dashboard')->with('success', 'Profil berhasil diperbarui.');
        }

        return redirect()->route('pendaftar.dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
}
