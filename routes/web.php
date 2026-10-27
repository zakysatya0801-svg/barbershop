<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureClientOwner;
use Illuminate\Support\Facades\Route;

// Menampilkan halaman utama.
Route::view('/', 'home.index')->name('home');

// Route halaman booking berdasarkan nama toko.
Route::get('/booking/{shop}', function (string $shop) {
    return 'Halaman Booking Barbershop: ' . e($shop);
})->name('booking');

// Menampilkan dashboard client berdasarkan nama toko.
Route::get('/dashboard/{shop}', function (string $shop) {
    return 'Dashboard Client Barbershop: ' . e($shop);
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

// Dashboard khusus Admin.
Route::view('/admin/dashboard', 'pages.admin.dashboard')
    ->middleware(['auth', EnsureAdmin::class])
    ->name('admin.dashboard');

// Halaman menu sidebar Owner.
Route::view('/barbershop', 'base-client.barbershop')
    ->name('owner.barbershop');

Route::view('/booking', 'base-client.booking')
    ->name('owner.booking');

Route::view('/barber', 'base-client.barber')
    ->name('owner.barber');

Route::view('/profil', 'base-client.profil')
    ->name('owner.profil');
