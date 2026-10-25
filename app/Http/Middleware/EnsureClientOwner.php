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

        // Mengarahkan Admin ke dashboard yang sesuai dengan rolenya.
        if ($user?->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        // Menolak akses jika akun tidak memiliki role owner.
        if (! $user || ! $user->hasRole('owner')) {
            abort(403, 'Anda tidak memiliki akses sebagai client.');
        }

        // Melanjutkan request jika pemeriksaan berhasil.
        return $next($request);
    }
}
