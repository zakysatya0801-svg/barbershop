<?php

namespace App\Http\Middleware;

use App\Support\ShopContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveShopContext
{
    public function handle(
        Request $request,
        Closure $next,
        ShopContext $shopContext
    ): Response {
        $user = $request->user();

        // Pastikan pengguna sudah login dan aktif
        if (!$user || !$user->isActive()) {
            abort(403, 'Akses ditolak.');
        }

        // Pastikan pengguna memiliki role Owner
        $admin = $user->admin;

        if (!$admin || $admin->role !== 'owner') {
            abort(403, 'Akses khusus Owner.');
        }

        // Ambil data Owner berdasarkan akun yang login
        $owner = $admin->owners()
            ->with('goBarberShops')
            ->first();

        if (!$owner) {
            abort(403, 'Data Owner tidak ditemukan.');
        }

        // Ambil barbershop milik Owner
        $shop = $owner->goBarberShops->first();

        if (!$shop) {
            abort(403, 'Owner belum memiliki barbershop.');
        }

        // Simpan barbershop aktif ke ShopContext
        $shopContext->set($shop);

        return $next($request);
    }
}