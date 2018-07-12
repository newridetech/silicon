<?php

namespace Newride\Silicon\bundles\keycloak\Providers;

use Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Newride\Silicon\bundles\keycloak\Auth\Guard\KeycloakSession as KeycloakSessionGuard;
use Newride\Silicon\bundles\keycloak\Auth\Guard\KeycloakToken as KeycloakTokenGuard;
use Newride\Silicon\bundles\keycloak\Auth\UserProvider\Keycloak as KeycloakUserProvider;
use Newride\Silicon\bundles\keycloak\Contracts\AuthenticationReceiver as AuthenticationReceiverContract;
use Newride\Silicon\bundles\keycloak\Services\SimpleAuthenticationReceiver as AuthenticationReceiverImplementation;
use pviojo\OAuth2\Client\Provider\Keycloak;

class KeycloakProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Newride\Silicon\app\Model' => 'Newride\Silicon\app\Policies\ModelPolicy',
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
        $this->mergeConfigFrom(__DIR__.'/../config/keycloak.php', 'keycloak');

        $this->app->singleton(Keycloak::class, function () {
            return new Keycloak(config('keycloak'));
        });

        $this->app->bind(
            AuthenticationReceiverContract::class,
            AuthenticationReceiverImplementation::class
        );
    }

    public function registerGates()
    {
    }

    public function registerGuards()
    {
        Auth::extend('keycloak.session', function ($app, $name, array $config) {
            return $app->make(KeycloakSessionGuard::class);
        });

        Auth::extend('keycloak.token', function ($app, $name, array $config) {
            return $app->make(KeycloakTokenGuard::class);
        });

        Auth::provider('keycloak', function ($app, array $config) {
            return $app->make(KeycloakUserProvider::class);
        });
    }
}
