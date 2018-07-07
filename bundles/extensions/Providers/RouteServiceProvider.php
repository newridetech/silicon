<?php

namespace Newride\Laroak\bundles\extensions\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        $this->mapBundlesRoutes();
        $this->mapExtensionsRoutes();
    }

    protected function mapBundlesRoutes(): void
    {
        Route::middleware('web')->group(__DIR__.'/../../keycloak/routes/web.php');
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapExtensionsRoutes(): void
    {
        $extensions = $this->app->make('extensions');
        $namespace = $extensions->getBaseNamespace();

        foreach ($extensions->routes('web') as $name => $path) {
            Route::as($name.'.')
                ->middleware([
                    // order is important here, 'web' middleware needs to be
                    // first as it resolves session that is required to
                    // authenticate and validate extension user
                    'web',

                    sprintf('extension:%s', $name),
                ])
                ->namespace($namespace.$name.'\Http\Controllers')
                ->group($path)
            ;
        }
    }
}
