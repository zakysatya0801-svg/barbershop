<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureClientOwner
{
    /**
     * Memastikan pengguna sudah login dan memiliki role owner.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Mengambil akun pengguna yang sedang login.
        $user = $request->user();

        // Menolak akses jika akun tidak memiliki role owner.
        if (! $user || $user->admin?->role !== 'owner') {
            abort(403, 'Anda tidak memiliki akses sebagai client.');
        }

        // Melanjutkan request jika pemeriksaan berhasil.
        return $next($request);
    }
}
