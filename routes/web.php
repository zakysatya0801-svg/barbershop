
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarbershopQrScanController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\ShopExploreController;
use App\Http\Middleware\EnsureClientOwner;
use App\Http\Middleware\ResolveShopContext;
// Controller untuk pengelolaan barber dan service oleh Owner.
use App\Http\Controllers\Owner\BarberController;
use App\Http\Controllers\Owner\ServiceController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'customer.home.index')->name('home');

Route::get('/qr/{token}', BarbershopQrScanController::class)
    ->name('barbershops.qr.scan');

Route::get('/booking/{shop}', function (string $shop) {
    return 'Halaman Booking Barbershop: '.e($shop);
})->name('booking');

Route::get('/dashboard/{shop}', function (string $shop) {
    return 'Dashboard Client Barbershop: '.e($shop);
})
    ->middleware(['auth', EnsureClientOwner::class])
    ->name('dashboard');

Route::get('/jelajah-barbershop', [ShopExploreController::class, 'index'])
    ->name('shops.explore');

Route::get('/barbershop/{shop}/detail', [ShopDetailController::class, 'show'])
    ->name('shops.show');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

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
    });

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
