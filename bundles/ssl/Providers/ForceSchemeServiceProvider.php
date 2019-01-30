<?php

namespace Newride\Silicon\bundles\ssl\Providers;

use Illuminate\Support\ServiceProvider;
use function League\Uri\parse;
use URL;

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
