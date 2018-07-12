<?php

namespace Newride\Silicon\bundles\complete\Providers;

use Illuminate\Support\ServiceProvider;

class SiliconServiceProvider extends ServiceProvider
{
    protected static $providers = [
        \Newride\Silicon\bundles\extensions\Providers\ExtensionsServiceProvider::class,
        \Newride\Silicon\bundles\extensions\Providers\ExtensionDirectiveServiceProvider::class,
        \Newride\Silicon\bundles\extensions\Providers\RouteServiceProvider::class,
        \Newride\Silicon\bundles\keycloak\Providers\KeycloakProvider::class,
        \Newride\Silicon\bundles\ssl\Providers\ForceSchemeServiceProvider::class,
        \Newride\Silicon\bundles\content\Providers\ContentServiceProvider::class,
    ];

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/silicon.php', 'silicon');

        foreach (static::$providers as $provider) {
            $this->app->register($provider);
        }
    }
}
