
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\ShopExploreController;
use App\Http\Controllers\BookingController;

use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureClientOwner;
use App\Http\Middleware\ResolveShopContext;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA PELANGGAN
|--------------------------------------------------------------------------
*/

Route::view('/', 'customer.home.index')
    ->name('home');

/*
|--------------------------------------------------------------------------
| JELAJAH DAN DETAIL BARBERSHOP
|--------------------------------------------------------------------------
*/

Route::get('/jelajah-barbershop', [ShopExploreController::class, 'index'])
    ->name('shops.explore');

Route::get('/barbershop/{shop}/detail', [ShopDetailController::class, 'show'])
    ->name('shops.show');

/*
|--------------------------------------------------------------------------
| BOOKING PELANGGAN
|--------------------------------------------------------------------------
| Langkah 1: Pilih layanan
| Langkah 2: Pilih barber dan jadwal
| Langkah 3: Pembayaran
|--------------------------------------------------------------------------
*/

// Langkah 1 - Menampilkan pilihan layanan
Route::get('/booking/{shop}', [BookingController::class, 'services'])
    ->name('booking');

// Menyimpan layanan yang dipilih
Route::post('/booking/{shop}/layanan', [BookingController::class, 'storeServices'])
    ->name('booking.services.store');

// Langkah 2 - Menampilkan pilihan barber dan jadwal
Route::get('/booking/{shop}/jadwal', [BookingController::class, 'schedule'])
    ->name('booking.schedule');

// Menyimpan barber, tanggal, dan jam
Route::post('/booking/{shop}/jadwal', [BookingController::class, 'storeSchedule'])
    ->name('booking.schedule.store');

// Langkah 3 - Menampilkan halaman pembayaran
Route::get('/booking/{shop}/pembayaran', [BookingController::class, 'payment'])
    ->name('booking.payment');

// Konfirmasi pembayaran (sementara simulasi)
Route::post('/booking/{shop}/pembayaran', [BookingController::class, 'confirmPayment'])
    ->name('booking.payment.confirm');

/*
|--------------------------------------------------------------------------
| DASHBOARD CLIENT
|--------------------------------------------------------------------------
*/

Route::get('/dashboard/{shop}', function (string $shop) {
    return 'Dashboard Client Barbershop: ' . e($shop);
})
    ->middleware(['auth', EnsureClientOwner::class])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTENTIKASI
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::view('/admin/dashboard', 'pages.admin.dashboard')
    ->middleware(['auth', EnsureAdmin::class])
    ->name('admin.dashboard');

/*
|--------------------------------------------------------------------------
| HALAMAN OWNER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', ResolveShopContext::class])
    ->prefix('owner')
    ->name('owner.')
    ->group(function (): void {

        Route::view('/barbershop', 'base-client.barbershop')
            ->name('barbershop');

        Route::view('/booking', 'base-client.booking')
            ->name('booking');

        Route::view('/barber', 'base-client.barber')
            ->name('barber');

        Route::view('/profil', 'base-client.profil')
            ->name('profil');
        Route::get('/booking/{shop}/berhasil', [BookingController::class, 'success'])
             ->name('booking.success');
    });
