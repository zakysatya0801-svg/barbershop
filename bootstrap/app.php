<?php

use App\Http\Middleware\SetTenantContext;
use App\Support\Routing\PortalRoutes;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // Mendaftarkan route web utama.
        web: __DIR__.'/../routes/web.php',

        // Mendaftarkan perintah Artisan.
        commands: __DIR__.'/../routes/console.php',

        // Mendaftarkan endpoint pemeriksaan kesehatan.
        health: '/up',

        // Mendaftarkan route tambahan.
        then: function (): void {
            // Route khusus client dengan middleware web.
            Route::middleware('web')
                ->group(base_path('routes/client.php'));

            // Mendaftarkan route portal.
            PortalRoutes::register();
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias middleware untuk pemeriksaan role pengguna.
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'tenant' => SetTenantContext::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
