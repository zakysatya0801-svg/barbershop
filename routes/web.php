
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\ShopExploreController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureClientOwner;
use App\Http\Middleware\ResolveShopContext;
use Illuminate\Support\Facades\Route;

Route::view('/', 'customer.home.index')->name('home');

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

Route::view('/admin/dashboard', 'pages.admin.dashboard')
    ->middleware(['auth', EnsureAdmin::class])
    ->name('admin.dashboard');

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
