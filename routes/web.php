<?php

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TopikController;

Route::get('/', function () {
    return view('auth/landing');
});

Route::get('/login', function () {
    return view('auth/login');
});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [LoginController::class, 'register']);


Route::get('/dashboard', [LoginController::class, 'adminDashboard'])->name('admin.dashboard'); 
Route::get('/home', [LoginController::class, 'userDashboard'])->name('user.dashboard');

Route::get('/register', function () {
    return view('auth/register');
});


Route::get('/topik', [TopikController::class, 'index'])->name('topik.index');
Route::post('/topik', [TopikController::class, 'store']);
Route::delete('/topik/{id}', [TopikController::class, 'destroy'])->name('topik.destroy');
Route::put('/topik/{id}', [TopikController::class, 'update'])->name('topik.update');



