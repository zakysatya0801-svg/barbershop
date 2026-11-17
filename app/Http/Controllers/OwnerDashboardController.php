<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class OwnerDashboardController extends Controller
{
    /**
     * Menampilkan dashboard dan seluruh barbershop milik Owner.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        // Mengambil data Admin dari akun yang sedang login.
        $admin = $user->admin;

        if (! $admin) {
            abort(403, 'Data Admin tidak ditemukan.');
        }

        // Mengambil data Owner beserta seluruh barbershop miliknya.
        $owner = $admin->owners()
            ->with('goBarberShops')
            ->first();

        if (! $owner) {
            abort(403, 'Data Owner tidak ditemukan.');
        }

        $barbershops = $owner->goBarberShops;

        return view('base-client.dashboard', [
            'owner' => $owner,
            'barbershops' => $barbershops,
            'totalBarbershops' => $barbershops->count(),
        ]);
    }
}
