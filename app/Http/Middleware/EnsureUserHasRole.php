<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(
        Request $request,
        Closure $next,
        string $role
    ): Response {
        $user = $request->user();

        if ($user === null) {
            abort(403, 'Akses ditolak: Anda tidak memiliki hak akses.');
        }

        if ($user->hasRole($role)) {
            return $next($request);
        }

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('owner')) {
            return redirect()->route('client.dashboard');
        }

        abort(403, 'Akses ditolak: Anda tidak memiliki hak akses.');
    }
}
