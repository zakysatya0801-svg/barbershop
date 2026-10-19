<?php

use Illuminate\Support\Facades\Route;

// Route halaman utama Laravel.
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route halaman booking barbershop.
Route::get('/booking/{shop}', function ($shop) {
    return 'Halaman Booking Barbershop: ' . e($shop);
})->name('booking');

// Route dashboard AdminLTE.
Route::view('/admin/dashboard', 'pages.admin.dashboard')
    ->name('admin.dashboard');
