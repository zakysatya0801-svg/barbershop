
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopExploreController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\ResolveShopContext;

/*
|--------------------------------------------------------------------------
| HALAMAN PELANGGAN
|--------------------------------------------------------------------------
*/

// Halaman Home
Route::view('/', 'customer.home.index')
    ->name('home');

// Halaman Jelajah Barbershop
Route::get('/jelajah-barbershop', [ShopExploreController::class, 'index'])
    ->name('shops.explore');

// Halaman Detail Barbershop
Route::get('/barbershop/{shop}', [ShopDetailController::class, 'show'])
    ->name('shops.show');


/*
|--------------------------------------------------------------------------
| BOOKING PELANGGAN
|--------------------------------------------------------------------------
*/

// Halaman Booking (sementara placeholder)
Route::get('/booking/{shop}', function ($shop) {
    return 'Halaman Booking Barbershop: ' . e($shop);
})->name('booking');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

// Halaman Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

// Proses Login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| DASHBOARD ADMIN
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
    ->group(function () {

        Route::view('/barbershop', 'base-client.barbershop')
            ->name('barbershop');

        Route::view('/booking', 'base-client.booking')
            ->name('booking');

        Route::view('/barber', 'base-client.barber')
            ->name('barber');

        Route::view('/profil', 'base-client.profil')
            ->name('profil');

    });
