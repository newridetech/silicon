<?php

namespace Newride\Laroak\bundles\content\Providers;

use Illuminate\Support\ServiceProvider;

class ContentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    public function register(): void
    {
    }
}
