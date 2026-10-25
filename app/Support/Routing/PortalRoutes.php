<?php

namespace App\Support\Routing;

use Illuminate\Support\Facades\Route;

class PortalRoutes
{
    public static function register(): void
    {
        $customerRoutes = base_path('routes/customer.php');

        if (file_exists($customerRoutes)) {
            Route::middleware(['web'])
                ->prefix('barbershop/{shop}')
                ->as('customer.')
                ->group($customerRoutes);
        }

        $clientRoutes = base_path('routes/client.php');

        if (file_exists($clientRoutes)) {
            Route::middleware(['web', 'auth', 'role:owner'])
                ->prefix('client/{shop}')
                ->as('client.')
                ->group($clientRoutes);
        }

        $adminRoutes = base_path('routes/admin.php');

        if (file_exists($adminRoutes)) {
            Route::middleware(['web', 'auth', 'role:admin'])
                ->prefix('admin')
                ->as('admin.')
                ->group($adminRoutes);
        }
    }
}
