<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureClientOwner;
use Illuminate\Support\Facades\Route;

// Menampilkan halaman utama.
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route halaman booking barbershop.
Route::get('/booking/{shop}', function (string $shop) {
    return 'Halaman Booking Barbershop: '.e($shop);
})->name('booking');

// Menampilkan dashboard berdasarkan nama toko.
Route::get('/dashboard/{shop}', function (string $shop) {
    return 'Dashboard Client Barbershop: '.e($shop);
})
    ->middleware(['auth', EnsureClientOwner::class])
    ->name('dashboard');

// Menampilkan halaman login Admin dan Owner.
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

// Memproses login.
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Mengakhiri sesi login.
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
