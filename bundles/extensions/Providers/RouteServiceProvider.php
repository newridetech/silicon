<?php

namespace Newride\Laroak\bundles\extensions\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

abstract class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Newride\\change_me';

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapExtensionsRoutes(): void
    {
        foreach ($this->app->make('extensions')->routes('web') as $name => $path) {
            Route::as($name.'.')
                ->middleware([
                    // order is important here, 'web' middleware needs to be
                    // first as it resolves session that is required to
                    // authenticate and validate extension user
                    'web',

                    sprintf('extension:%s', $name),
                ])
                ->namespace($this->namespace.'\\extensions\\'.$name.'\Http\Controllers')
                ->group($path)
            ;
        }
    }
}
