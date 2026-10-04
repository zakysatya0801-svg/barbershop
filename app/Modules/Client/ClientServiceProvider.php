<?php

namespace App\Modules\Client;

use App\Modules\ModuleServiceProvider;

final class ClientServiceProvider extends ModuleServiceProvider
{
    public function register(): void
    {
        //
    }

    protected function moduleAlias(): string
    {
        return 'client';
    }
}