<?php

use App\Models\Owner;
use Illuminate\Support\Facades\Route;

// Dashboard berdasarkan nama toko.
Route::get('/dashboard/{shop}', function (string $shop) {
    return 'Dashboard Client Barbershop: ' . e($shop);
})->name('dashboard');

// Dashboard khusus Owner yang sudah login.
Route::get('/client/dashboard', function () {
    // Mengambil pengguna yang sedang login.
    $user = request()->user();

    // Mengambil data admin yang terhubung dengan pengguna.
    $admin = $user?->admin;

    // Memastikan pengguna memiliki role Owner.
    abort_if(
        !$admin || $admin->role !== 'owner',
        403,
        'Akses ditolak.'
    );

    // Mengambil profil Owner berdasarkan admin yang login.
    $owner = Owner::where('admin_id', $admin->admin_id)->first();

    // Memastikan profil Owner tersedia.
    abort_if(!$owner, 403, 'Profil Owner tidak ditemukan.');

    // Mengambil seluruh barbershop milik Owner.
    $barbershops = $owner->goBarberShops()->get();

    // Menampilkan dashboard Owner.
    return view(
        'base-client.dashboard',
        compact('owner', 'barbershops')
    );
})
    ->middleware([
        'auth',
        \App\Http\Middleware\EnsureClientOwner::class,
    ])
    ->name('client.dashboard');
