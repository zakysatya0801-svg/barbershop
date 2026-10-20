<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Middleware untuk memeriksa konteks dan kepemilikan barbershop.
use App\Http\Middleware\SetTenantContext;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // Mendaftarkan route web utama.
        web: __DIR__.'/../routes/web.php',

        // Mendaftarkan route khusus client dengan middleware web.
        then: function (): void {
            Route::middleware('web')
                ->group(base_path('routes/client.php'));
        },

        // Mendaftarkan perintah Artisan.
        commands: __DIR__.'/../routes/console.php',

        // Mendaftarkan endpoint pemeriksaan kesehatan.
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
    // Mendaftarkan alias untuk resolver konteks barbershop.
    $middleware->alias([
        'tenant' => SetTenantContext::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
