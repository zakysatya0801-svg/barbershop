<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarbershopQrScanController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Owner\BarberController;
use App\Http\Controllers\Owner\BarbershopController;
use App\Http\Controllers\Owner\BookingController as OwnerBookingController;
use App\Http\Controllers\Owner\ProfileController;
use App\Http\Controllers\Owner\ServiceController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\ShopExploreController;
use App\Http\Middleware\EnsureClientOwner;
use Illuminate\Support\Facades\Route;

Route::view('/', 'customer.home.index')
    ->name('home');

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

Route::get('/jelajah-barbershop', [ShopExploreController::class, 'index'])
    ->name('shops.explore');

Route::get('/barbershop/{shop}/detail', [ShopDetailController::class, 'show'])
    ->name('shops.show');

Route::get('/qr/{token}', BarbershopQrScanController::class)
    ->name('barbershops.qr.scan');

Route::get('/booking/{shop}', [BookingController::class, 'services'])
    ->name('booking');

Route::post('/booking/{shop}/layanan', [BookingController::class, 'storeServices'])
    ->name('booking.services.store');

Route::get('/booking/{shop}/jadwal', [BookingController::class, 'schedule'])
    ->name('booking.schedule');

Route::post('/booking/{shop}/jadwal', [BookingController::class, 'storeSchedule'])
    ->name('booking.schedule.store');

Route::get('/booking/{shop}/pembayaran', [BookingController::class, 'payment'])
    ->name('booking.payment');

Route::post('/booking/{shop}/pembayaran', [BookingController::class, 'confirmPayment'])
    ->name('booking.payment.confirm');

Route::get('/booking/{shop}/berhasil', [BookingController::class, 'success'])
    ->name('booking.success');

Route::get('/dashboard/{shop}', function (string $shop) {
    return 'Dashboard Client Barbershop: '.e($shop);
})
    ->middleware(['auth', EnsureClientOwner::class])
    ->name('dashboard');

Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])
    ->middleware(['auth', EnsureClientOwner::class])
    ->name('owner.dashboard');

Route::middleware(['auth', EnsureClientOwner::class])
    ->prefix('owner')
    ->name('owner.')
    ->group(function (): void {
        Route::get('/barbershop', [BarbershopController::class, 'index'])
            ->name('barbershop');

        Route::get('/barbershop/create', [BarbershopController::class, 'create'])
            ->name('barbershop.create');

        Route::post('/barbershop', [BarbershopController::class, 'store'])
            ->name('barbershop.store');

        Route::get('/barbershop/{id}/edit', [BarbershopController::class, 'edit'])
            ->name('barbershop.edit');

        Route::put('/barbershop/{id}', [BarbershopController::class, 'update'])
            ->name('barbershop.update');

        Route::get('/barber', [BarberController::class, 'index'])
            ->name('barber');

        Route::get('/barber/create', [BarberController::class, 'create'])
            ->name('barber.create');

        Route::post('/barber', [BarberController::class, 'store'])
            ->name('barber.store');

        Route::delete('/barber/{barber}', [BarberController::class, 'destroy'])
            ->name('barber.destroy');

        Route::get('/service', [ServiceController::class, 'index'])
            ->name('service');

        Route::get('/service/create', [ServiceController::class, 'create'])
            ->name('service.create');

        Route::post('/service', [ServiceController::class, 'store'])
            ->name('service.store');

        Route::delete('/service/{id}', [ServiceController::class, 'destroy'])
            ->name('service.destroy');

        Route::get('/booking', [OwnerBookingController::class, 'index'])
            ->name('booking');

        Route::get('/profil', [ProfileController::class, 'edit'])
            ->name('profil');

        Route::put('/profil', [ProfileController::class, 'update'])
            ->name('profil.update');
    });
