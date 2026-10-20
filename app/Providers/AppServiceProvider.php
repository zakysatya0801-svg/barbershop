<?php

namespace App\Providers;

use App\Support\Tenancy\TenantContext;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Scoped: satu instance per request/job; di-reset pada lifecycle berikutnya
        $this->app->scoped(
            TenantContext::class,
            fn (): TenantContext => new TenantContext,
        );
    }

    public function boot(): void
    {
        //
    }
}
