<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    // Memastikan hanya akun dengan role admin yang bisa melanjutkan.
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $user->admin?->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses sebagai Admin.');
        }

        return $next($request);
    }
}
