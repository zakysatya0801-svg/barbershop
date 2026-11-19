<?php

namespace App\Http\Controllers;

// Import Request untuk mengambil data pengguna yang sedang login.
use Illuminate\Http\Request;
// Import View sebagai tipe nilai kembalian halaman.
use Illuminate\View\View;

// Nama class harus OwnerDashboardController,
// karena nama file-nya juga OwnerDashboardController.php.
class OwnerDashboardController extends Controller
{
    /**
     * Menampilkan dashboard Owner.
     */
    public function index(Request $request): View
    {
        // Mengambil pengguna yang sedang login.
        $user = $request->user();

        // Mengambil data Admin yang terhubung dengan pengguna.
        $admin = $user->admin;

        // Pastikan data Admin tersedia.
        if (! $admin) {
            abort(403, 'Data Admin tidak ditemukan.');
        }

        // Mengambil data Owner beserta seluruh barbershop miliknya.
        $owner = $admin->owners()
            ->with('goBarberShops')
            ->first();

        // Pastikan data Owner tersedia.
        if (! $owner) {
            abort(403, 'Data Owner tidak ditemukan.');
        }

        // Mengambil koleksi barbershop milik Owner.
        $barbershops = $owner->goBarberShops;

        // Mengirim data ke halaman dashboard Owner.
        return view('base-client.dashboard', [
            'owner' => $owner,
            'barbershops' => $barbershops,
            'totalBarbershops' => $barbershops->count(),
        ]);
    }
}
