
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function ($shop) {
    return view('layouts.customer', [
        'shop' => $shop,
        'content' => '<h2>Selamat datang di GoBarber!</h2>',
    ]);
})->name('home');