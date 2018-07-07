<?php

namespace Newride\Laroak\bundles\extensions\Providers;

use Illuminate\Support\ServiceProvider;
use Newride\Laroak\bundles\extensions\Services\Extensions;

class ExtensionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('extensions', function ($app) {
            $extensions = $app->make(Extensions::class);
            $extensions->preload();

            return $extensions;
        });

        foreach ($this->app->make('extensions')->all() as $extension) {
            $this->app->register($extension);
        }
    }
}
