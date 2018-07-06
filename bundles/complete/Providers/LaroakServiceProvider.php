<?php

namespace Newride\Laroak\bundles\complete\Providers;

use Illuminate\Support\ServiceProvider;

class LaroakServiceProvider extends ServiceProvider
{
    protected static $providers = [
        \Newride\Laroak\bundles\extensions\Providers\ExtensionsServiceProvider::class,
        \Newride\Laroak\bundles\extensions\Providers\ExtensionDirectiveServiceProvider::class,
        \Newride\Laroak\bundles\keycloak\Providers\KeycloakProvider::class,
        \Newride\Laroak\bundles\ssl\Providers\ForceSchemeServiceProvider::class,
        \Newride\Laroak\bundles\content\Providers\ContentServiceProvider::class,
    ];

    public function register(): void
    {
        foreach (static::$providers as $provider) {
            $this->app->register($provider);
        }
    }
}
