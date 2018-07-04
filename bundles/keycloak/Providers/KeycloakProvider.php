<?php

namespace Newride\Laroak\bundles\keycloak\Providers;

use Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Newride\Laroak\bundles\keycloak\Auth\Guard\KeycloakSession as KeycloakSessionGuard;
use Newride\Laroak\bundles\keycloak\Auth\UserProvider\Keycloak as KeycloakUserProvider;
use pviojo\OAuth2\Client\Provider\Keycloak;

class KeycloakProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Newride\Laroak\app\Model' => 'Newride\Laroak\app\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerGuards();
        $this->registerGates();
    }

    public function register()
    {
        $this->app->singleton(Keycloak::class, function () {
            return new Keycloak(config('keycloak'));
        });
    }

    public function registerGates()
    {
    }

    public function registerGuards()
    {
        Auth::extend('keycloak.session', function ($app, $name, array $config) {
            return $app->make(KeycloakSessionGuard::class);
        });

        Auth::provider('keycloak', function ($app, array $config) {
            return $app->make(KeycloakUserProvider::class);
        });
    }
}
