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

        if ($user === null || ! $user->hasRole($role)) {
            abort(403, 'Akses ditolak: Anda tidak memiliki hak akses.');
        }

        return $next($request);
    }
}