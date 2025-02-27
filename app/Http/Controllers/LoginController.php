<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $peserta = Peserta::where('username', $request->username)->first();

        if (!$peserta || !Hash::check($request->password, $peserta->password)) {
            return redirect()->back()->withErrors(['login' => 'Username atau password salah']);
        }

        $isAdmin = $peserta->username === 'bbpompadang';

        session([
            'auth_token' => bin2hex(random_bytes(40)),
            'user_id' => $peserta->id,
            'is_admin' => $isAdmin,
        ]);

        return $isAdmin ? redirect()->route('admin.dashboard') : redirect()->route('user.dashboard');
    }

    public function adminDashboard()
    {
        if (session('is_admin') !== true) {
            return redirect()->route('user.dashboard');
        }

        return view('layout.dashboard');
    }

    public function userDashboard()
    {
        return view('layout.home');
    }

    public function register(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:peserta',
            'email' => 'required|string|email|max:255|unique:peserta',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        
        $id = DB::table('peserta')->insertGetId([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Session::put('user_id', $id);
        Session::put('username', $request->username);
        Session::put('nama', $request->nama);
        Session::put('email', $request->email);

        return redirect()->route('user.dashboard')->with('success', 'Registrasi berhasil!');
    }


    public function logout()
    {
        session()->forget('auth_token');
        return redirect('/login');
    }
}
