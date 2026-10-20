
<?php

// Mengimpor Route Laravel dan controller autentikasi.
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Menampilkan halaman utama bawaan Laravel.
Route::get('/', function () {
    return view('welcome');
});

// Menampilkan halaman login Admin dan Owner.
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

// Memproses email dan password dari form login.
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Mengakhiri sesi login pengguna.
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Menampilkan dashboard Admin setelah pengguna login.
// Pembatasan berdasarkan role akan ditambahkan berikutnya.
Route::view('/admin/dashboard', 'pages.admin.dashboard')
    ->middleware('auth')
    ->name('admin.dashboard');
