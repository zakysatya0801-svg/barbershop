<?php

use App\Modules\Admin\Http\Controllers\AdminBarbershopQrCodeController;
use App\Modules\Admin\Http\Controllers\AdminCommissionController;
use App\Modules\Admin\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

Route::post(
    '/barbershops/{barbershop}/commission-schemes',
    [AdminCommissionController::class, 'store']
)->name('barbershops.commission-schemes.store');

Route::post(
    '/barbershops/{barbershop}/qr-code',
    [AdminBarbershopQrCodeController::class, 'store']
)->name('barbershops.qr-code.store');
