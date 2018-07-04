<?php

namespace Newride\Laroak\bundles\ssl\Providers;

use Illuminate\Support\ServiceProvider;
use URL;
use function League\Uri\parse;

class ForceSchemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $url = parse(config('app.url'));

        URL::forceScheme($url['scheme']);
    }
}
