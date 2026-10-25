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

        if ($user?->hasRole('admin')) {
            return $next($request);
        }

        if ($user?->hasRole('owner')) {
            return redirect()->route('client.dashboard');
        }

        abort(403, 'Anda tidak memiliki akses sebagai Admin.');
    }
}
