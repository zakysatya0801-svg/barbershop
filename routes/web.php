<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/booking/{shop}', function ($shop) {
    return 'Halaman Booking Barbershop: ' . e($shop);
})->name('booking');
