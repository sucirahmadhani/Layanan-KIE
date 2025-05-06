<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function loginpage()
    {
        return view('auth.login');
    }

    public function registerpage()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $pengguna = Pengguna::where('username', $request->username)->first();

        if ($pengguna && Hash::check($request->password, $pengguna->password)) {
            Auth::login($pengguna);

            if ($pengguna->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($pengguna->role === 'pendaftar') {
                if (!$pengguna->email_verified_at) {
                    return redirect()->route('verifikasi-email');
                }
                return redirect()->route('pendaftar.dashboard');
            }

            if ($pengguna->role === 'peserta') {
                if ($pengguna->expired_at && now()->greaterThan($pengguna->expired_at)) {
                    Auth::logout();
                    return back()->withErrors(['username' => 'Akun Anda sudah expired.']);
                }

                if ($pengguna->profile_updated) {
                    return redirect()->route('peserta.dashboard');
                } else {
                    return redirect()->route('peserta.editProfile');
                }
            }
        }

        return redirect()->back()->withErrors(['login' => 'Username atau password salah.']);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:pengguna,username',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Pengguna::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'Email sudah terdaftar.'])->withInput();
        }

        $pengguna = Pengguna::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => 'pendaftar',
        ]);

        Auth::login($pengguna);

        $pengguna->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }

    public function adminDashboard()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('user.dashboard');
        }

        return view('layout.dashboard');
    }

    public function pendaftarDashboard()
    {
        return view('layout.home');
    }

    public function showVerifyPage()
    {
        return view('auth.verify-email');
    }

    public function sendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'Email verifikasi telah dikirim ulang!');
    }

    public function verify(Request $request)
    {
        if (!Auth::check()) {
            $pengguna = Pengguna::findOrFail($request->route('id'));
            Auth::login($pengguna);
        }

        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/home');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect('/home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:pengguna,email',
        ]);

        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        Mail::raw('Klik link berikut untuk reset password kamu: ' . $resetLink, function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('success', 'Link reset password sudah dikirim ke email kamu.');
    }

    public function showResetPasswordForm($token, Request $request)
    {
        $email = $request->query('email');
        return view('auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:pengguna,email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Token tidak valid atau sudah kadaluarsa.']);
        }

        $pengguna = Pengguna::where('email', $request->email)->first();
        $pengguna->password = Hash::make($request->password);
        $pengguna->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password berhasil direset. Silakan login.');
    }
}
