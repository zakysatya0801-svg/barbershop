
<?php

// Mengimpor controller autentikasi.
use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureAdmin;
use Illuminate\Support\Facades\Route;

// Menampilkan halaman utama bawaan Laravel.
Route::get('/', function () {
    return view('welcome');
});

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
