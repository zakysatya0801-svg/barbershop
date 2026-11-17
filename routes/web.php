<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarbershopQrScanController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Owner\BarberController;
use App\Http\Controllers\Owner\ServiceController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\ShopExploreController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureClientOwner;
use App\Http\Middleware\ResolveShopContext;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA PELANGGAN
|--------------------------------------------------------------------------
*/

Route::view('/', 'customer.home.index')
    ->name('home');

/*
|--------------------------------------------------------------------------
| QR CODE BARBERSHOP
|--------------------------------------------------------------------------
*/

Route::get('/qr/{token}', BarbershopQrScanController::class)
    ->name('barbershops.qr.scan');

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

// Konfirmasi pembayaran
Route::post('/booking/{shop}/pembayaran', [BookingController::class, 'confirmPayment'])
    ->name('booking.payment.confirm');

Route::get('/booking/{shop}/berhasil', [BookingController::class, 'success'])
    ->name('booking.success');

/*
|--------------------------------------------------------------------------
| DASHBOARD CLIENT
|--------------------------------------------------------------------------
*/

Route::get('/dashboard/{shop}', function (string $shop) {
    return 'Dashboard Client Barbershop: '.e($shop);
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

Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])
    ->middleware(['auth', EnsureClientOwner::class])
    ->name('client.dashboard');
Route::middleware(['auth', ResolveShopContext::class])
    ->prefix('owner')
    ->name('owner.')
    ->group(function (): void {

        // Halaman pengelolaan barbershop.
        Route::view('/barbershop', 'base-client.barbershop')
            ->name('barbershop');

        // Halaman pengelolaan booking.
        Route::view('/booking', 'base-client.booking')
            ->name('booking');

        // Halaman pengelolaan profil.
        Route::view('/profil', 'base-client.profil')
            ->name('profil');

        // CRUD barber.
        Route::get('/barber', [BarberController::class, 'index'])
            ->name('barber');

        Route::get('/barber/create', [BarberController::class, 'create'])
            ->name('barber.create');

        Route::post('/barber', [BarberController::class, 'store'])
            ->name('barber.store');

        Route::delete('/barber/{barber}', [BarberController::class, 'destroy'])
            ->name('barber.destroy');

        // CRUD service.
        Route::get('/service', [ServiceController::class, 'index'])
            ->name('service');

        Route::get('/service/create', [ServiceController::class, 'create'])
            ->name('service.create');

        Route::post('/service', [ServiceController::class, 'store'])
            ->name('service.store');

        Route::delete('/service/{service}', [ServiceController::class, 'destroy'])
            ->name('service.destroy');
    });
