
<?php

use Illuminate\Support\Facades\Route;

// Route halaman utama Laravel.
Route::get('/', function () {
    return view('welcome');
});

// Route untuk menampilkan dashboard AdminLTE.
Route::view('/admin/dashboard', 'pages.admin.dashboard')
    ->name('admin.dashboard');

    