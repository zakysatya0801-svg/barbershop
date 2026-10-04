<?php

namespace App\Modules;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;

abstract class ModuleServiceProvider extends ServiceProvider
{
    abstract protected function moduleAlias(): string;

    public function boot(): void
    {
        $path = $this->modulePath();

        $this->loadViewsFrom(
            $path . '/resources/views',
            $this->moduleAlias()
        );

        $routesPath = $path . '/routes';

        if (is_dir($routesPath)) {
            foreach (glob($routesPath . '/*.php') ?: [] as $routeFile) {
                $this->loadRoutesFrom($routeFile);
            }
        }
    }

    protected function modulePath(): string
    {
        return dirname(
            (string) (new ReflectionClass($this))->getFileName()
        );
    }
}