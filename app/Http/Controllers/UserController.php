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
            'phone_number' => 'required|string|max:20',
        ]);

        $pengguna = Auth::user();

        if (!$pengguna) {
            return redirect('/login')->withErrors(['error' => 'Silakan login terlebih dahulu']);
        }

        $pengguna->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $pengguna = Auth::user();

        if (!$pengguna || !Hash::check($request->old_password, $pengguna->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
        }

        $pengguna->password = Hash::make($request->new_password);
        $pengguna->save();

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
