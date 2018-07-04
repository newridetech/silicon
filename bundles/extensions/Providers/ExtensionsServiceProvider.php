<?php

namespace Newride\Laroak\bundles\extensions\Providers;

use Illuminate\Support\ServiceProvider;
use Newride\Laroak\bundles\extensions\Services\Extensions;

class ExtensionsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->make('extensions')->boot();
    }

    public function register(): void
    {
        $this->app->singleton('extensions', function ($app) {
            $extensions = $app->make(Extensions::class);
            $extensions->preload();

            return $extensions;
        });
        $this->app->make('extensions')->register();
    }
}
