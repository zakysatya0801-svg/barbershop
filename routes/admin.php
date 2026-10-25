<?php

use App\Modules\Admin\Http\Controllers\AdminCommissionController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('pages.admin.dashboard');
})->name('dashboard');

Route::post(
    '/barbershops/{barbershop}/commission-schemes',
    [AdminCommissionController::class, 'store']
)->name('barbershops.commission-schemes.store');
