<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureAdmin;
use Illuminate\Support\Facades\Route;

// Menampilkan halaman utama (home).
Route::view('/', 'home.index')->name('home');

// Route halaman booking barbershop.
Route::get('/booking/{shop}', function (string $shop) {
    return 'Halaman Booking Barbershop: ' . e($shop);
})->name('booking');

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

// Dashboard hanya boleh diakses oleh Admin.
Route::view('/admin/dashboard', 'pages.admin.dashboard')
    ->middleware(['auth', EnsureAdmin::class])
    ->name('admin.dashboard');
// Halaman menu sidebar owner (sementara masih placeholder).
Route::view('/barbershop', 'base-client.barbershop')->name('owner.barbershop');
Route::view('/booking', 'base-client.booking')->name('owner.booking');
Route::view('/barber', 'base-client.barber')->name('owner.barber');
Route::view('/profil', 'base-client.profil')->name('owner.profil');