<?php

namespace App\Http\Middleware;

use App\Models\GoBarberShop;
use App\Support\Tenancy\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class SetTenantContext
{
    /**
     * Memastikan owner hanya mengakses barbershop miliknya.
     * Konteks aktif dibersihkan setelah request selesai.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Mengambil parameter barbershop dari route.
        $barbershop = $request->route('barbershop');

        // Mendukung route model binding maupun parameter ID.
        if (! $barbershop instanceof GoBarberShop) {
            $barbershop = GoBarberShop::query()->find($barbershop);
        }

        // Barbershop tidak ditemukan.
        if (! $barbershop instanceof GoBarberShop) {
            abort(404, 'Barbershop tidak ditemukan.');
        }

        // Mengambil pengguna yang sedang login.
        $user = $request->user();

        // Guest seharusnya ditangani middleware auth.
        if (! $user) {
            abort(403, 'Silakan login terlebih dahulu.');
        }

        // Memastikan pengguna memiliki role owner.
        $admin = $user->admin;

        if (! $admin || $admin->role !== 'owner') {
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            abort(403, 'Akses khusus Owner.');
        }

        // Mengambil profil Owner yang terhubung dengan akun.
        $owner = $admin->owners()->first();

        if (! $owner) {
            abort(403, 'Profil Owner tidak ditemukan.');
        }

        // Memastikan barbershop merupakan milik Owner yang login.
        if ((int) $barbershop->owner_id !== (int) $owner->owner_id) {
            return redirect()->route('client.dashboard');
        }

        // Menyimpan konteks barbershop selama request berlangsung.
        $context = app(TenantContext::class);
        $context->set($barbershop);

        try {
            return $next($request);
        } finally {
            // Mencegah konteks tertinggal setelah request selesai.
            $context->clear();
        }
    }
}
