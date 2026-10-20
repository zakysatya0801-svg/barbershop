
<?php

use App\Models\Owner;
use Illuminate\Support\Facades\Route;

// Dashboard utama untuk Owner yang sudah login.
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

    // Menghentikan akses jika profil Owner belum tersedia.
    abort_if(!$owner, 403, 'Profil Owner tidak ditemukan.');

    // Mengambil seluruh barbershop milik Owner.
    $barbershops = $owner->goBarberShops()->get();

    // Menampilkan halaman dashboard Blade.
    return view(
        'base-client.dashboard',
        compact('owner', 'barbershops')
    );
})
    // Membatasi dashboard untuk pengguna login dengan role Owner.
    ->middleware([
        'auth',
        \App\Http\Middleware\EnsureClientOwner::class,
    ])
    ->name('client.dashboard');

// Dashboard untuk satu barbershop tertentu.
Route::get(
    '/client/barbershops/{barbershop}/dashboard',
    function (\App\Models\GoBarberShop $barbershop) {
        // Mengambil konteks barbershop yang divalidasi middleware.
        $context = app(\App\Support\Tenancy\TenantContext::class);

        // Mengembalikan informasi untuk pengujian middleware.
        return response()->json([
            'message' => 'Konteks barbershop berhasil diakses.',
            'barbershop_id' => $context->id(),
            'barbershop_name' => $barbershop->barbershop_name,
        ]);
    }
)
    // Memeriksa login dan kepemilikan barbershop.
    ->middleware(['auth', 'tenant'])
    ->whereNumber('barbershop')
    ->name('client.barbershops.dashboard');
