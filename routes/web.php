<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetailPesananController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UlasanProdukController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

// Route publik (login & register)
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', function () {
    return view('pages.auth.register');
})->name('registers');
// Dashboard admin (hanya admin yang bisa akses)
Route::get('/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['checkislogin', 'checkrole:admin'])
    ->name('home');
// Route resource UMKM (hanya pemilik yang bisa akses)
Route::resource('umkm', UmkmController::class)
    ->middleware(['checkislogin', 'checkrole:admin']);

// Route resource Warga (hanya admin)
Route::resource('warga', WargaController::class)
    ->middleware(['checkislogin', 'checkrole:admin']);

// Route resource User (hanya admin)
Route::resource('users', UserController::class)
    ->middleware(['checkislogin', 'checkrole:admin']);

// Hapus media UMKM (pemilik)
Route::delete('umkm/media/{media_id}', [UmkmController::class, 'destroyMedia'])
    ->middleware(['checkislogin', 'checkrole:admin'])
    ->name('umkm.media.delete');

// Logout (harus login)
Route::post('/auth/logout', [AuthController::class, 'logout'])
    ->middleware('checkislogin')
    ->name('auth.logout');

Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

Route::get('/kontak', function () {
    return view('pages.kontak');
})->name('kontak');

Route::resource('produk', ProdukController::class);

Route::resource('pesanan', PesananController::class);

Route::resource('detail_pesanan', DetailPesananController::class);

Route::resource('ulasan_produk', UlasanProdukController::class);

Route::delete('/umkm/media/{media}', [UmkmController::class, 'destroyMedia'])
    ->name('umkm.destroy_media');
