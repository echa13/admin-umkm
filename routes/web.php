<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

// Tampilkan halaman login
Route::get('/auth', [AuthController::class, 'index'])->name('login');

// Proses login (POST)
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

// Proses logout
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::resource('umkm', UmkmController::class);
Route::resource('warga', WargaController::class);
Route::resource('users', UserController::class);

// Route untuk halaman dashboard admin
Route::get('/', [AdminDashboardController::class, 'index'])
    ->name('home'); // <-- opsional, agar hanya user login bisa akses

Route::get('/register', function () {
    return view('pages.auth.register');
})->name('registers');
