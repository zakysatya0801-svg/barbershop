<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function (string $shop) {
    return 'Dashboard Client Barbershop: ' . e($shop);
})->name('dashboard');