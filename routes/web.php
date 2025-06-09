<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TopikController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\NarasumberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TesController;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/login', [LoginController::class, 'loginpage'])->name('login');
Route::get('/register', [LoginController::class, 'registerpage']);
Route::post('/register', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [LoginController::class, 'verify'])->name('verification.verify')->middleware('web');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Link verifikasi telah dikirim!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/verify-email', [LoginController::class, 'showVerifyPage'])->name('verify.email');
Route::post('/verify-email/send', [LoginController::class, 'sendVerificationEmail'])->name('verification.send');

Route::middleware(['auth'])->group(function () {

    // Route untuk dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/home', [DashboardController::class, 'home'])->name('pendaftar.dashboard');
    Route::get('/beranda', [DashboardController::class, 'beranda'])->name('peserta.dashboard');

    // Route untuk topik
    Route::get('/topik', [TopikController::class, 'index'])->name('topik.index');
    Route::post('/topik', [TopikController::class, 'store']);
    Route::delete('/topik/{id}', [TopikController::class, 'destroy'])->name('topik.destroy');
    Route::put('/topik/{id}', [TopikController::class, 'update'])->name('topik.update');

    // Route untuk layanan
    Route::get('/daftar', [LayananController::class, 'daftar']);
    Route::post('/daftar/store', [LayananController::class, 'store'])->name('layanan.store');
    Route::get('/proses', [LayananController::class, 'proses'])->name('proses.show');
    Route::post('/generate-akun', [LayananController::class, 'generateAkun'])->name('generate.akun');

    // Route untuk permintaan layanan
    Route::get('/permintaan', [LayananController::class, 'permintaan'])->name('layanan.permintaan');
    Route::get('/permintaan/{layanan_id}', [LayananController::class, 'edit'])->name('layanan.edit');
    Route::put('/permintaan/{layanan_id}', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/{layanan_id}', [LayananController::class, 'destroy'])->name('layanan.destroy');
    Route::post('/layanan/{id}/selesai', [LayananController::class, 'selesai'])->name('layanan.selesai');

    // Route untuk layanan realisasi
    Route::get('/layanan', [LayananController::class, 'realisasi'])->name('realisasi');
    Route::get('/layanan/{id}', [LayananController::class, 'realisasi_show'])->name('realisasi.show');
    Route::get('/layanan/{id}/edit', [LayananController::class, 'realisasi_edit'])->name('realisasi.edit');
    Route::post('/layanan/{id}', [LayananController::class, 'realisasi_store'])->name('realisasi.store');

    // Route untuk narasumber
    Route::get('/narasumber', [NarasumberController::class, 'index'])->name('narasumber.index');
    Route::post('/narasumber', [NarasumberController::class, 'store']);
    Route::delete('/narasumber/{narasumber_id}', [NarasumberController::class, 'destroy'])->name('narasumber.destroy');
    Route::put('/narasumber/{narasumber_id}', [NarasumberController::class, 'update'])->name('narasumber.update');


    // Route untuk profil
    Route::get('/profile', [UserController::class, 'edit'])->name('edit.profil');
    Route::post('/profil/update', [UserController::class, 'update'])->name('profil.update');
    Route::post('/profil/password', [UserController::class, 'updatePassword'])->name('profil.password');
    Route::get('/profil', [UserController::class, 'index'])->name('edit.profil');
    Route::get('/akun', [UserController::class, 'profile'])->name('peserta.editProfile');
    Route::post('/akun/update', [UserController::class, 'updateProfile'])->name('peserta.updateProfile');


    // Route untuk soal
    Route::get('/topik/{topik}/soal', [TopikController::class, 'soal'])->name('soal.show');
    Route::get('/soal/{topik}/create', [TopikController::class, 'soal_create'])->name('soal.create');
    Route::post('/soal/{topik}', [TopikController::class, 'soal_store'])->name('soal.store');
    Route::delete('/soal/{soal}', [TopikController::class, 'soal_destroy'])->name('soal.destroy');
    Route::get('/soal/{soal}/edit', [TopikController::class, 'soal_edit'])->name('soal.edit');
    Route::put('/soal/{soal}', [TopikController::class, 'soal_update'])->name('soal.update');

    // Route untuk test
    Route::get('/pretest/{layananId}/{topikId}', [TesController::class, 'pretest'])->name('pretest.index');
    Route::post('/pretest/{layananId}/{topikId}/next', [TesController::class, 'nextTopik'])->name('pretest.next');
    Route::post('/pretest/{layananId}/submit', [TesController::class, 'submit'])->name('pretest.submit');
    Route::get('/posttest/{layananId}/{topikId}', [TesController::class, 'posttest'])->name('posttest.index');
    Route::post('/posttest/{layananId}/{topikId}/next', [TesController::class, 'nextopik'])->name('posttest.next');
    Route::post('/posttest/{layanan}', [TesController::class, 'submitPosttest'])->name('posttest.submit');
    Route::post('/survey', [TesController::class, 'submitSurvey'])->name('survey.submit');
    Route::get('/sertifikat/{layananId}', [TesController::class, 'generate'])->name('sertifikat.generate');

    // Route untuk tes pendaftar
    Route::get('/pre-test/{layananId}/{topikId}', [TesController::class, 'pre_test'])->name('pendaftar.pretest');
    Route::post('/pre-test/{layananId}/{topikId}/next', [TesController::class, 'selanjutnya'])->name('pendaftar.next');
    Route::post('/pre-test/{layananId}/submit', [TesController::class, 'kirim'])->name('pendaftar.submit');
    Route::get('/post-test/{layananId}/{topikId}', [TesController::class, 'postest'])->name('pendaftar.postest');
    Route::post('/post-test/{layananId}/{topikId}/next', [TesController::class, 'topiknext'])->name('pendaftar.nextpost');
    Route::post('/post-test/{layanan}', [TesController::class, 'kirimtes'])->name('pendaftar.kirim');
    Route::post('/rating', [TesController::class, 'submitrating'])->name('rating.submit');

    // Route untuk riwayat
    Route::get('/riwayat', [LayananController::class, 'riwayat'])->name('riwayat');
    Route::get('/riwayat/{id}', [LayananController::class, 'detail_riwayat'])->name('riwayat.detail');
});

// Route untuk reset password
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [LoginController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.update');


Route::get('/cek-token', function () {
    return [
        'from-env' => env('FONNTE_TOKEN'),
        'from-config' => config('services.fonnte.token'),
    ];
});



