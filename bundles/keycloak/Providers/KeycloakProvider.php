<?php

namespace Newride\Silicon\bundles\keycloak\Providers;

use Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Newride\Silicon\bundles\extensions\Http\Middleware\CheckCanUseExtension as CheckCanUseExtensionMiddleware;
use Newride\Silicon\bundles\keycloak\Auth\Guard\KeycloakSession as KeycloakSessionGuard;
use Newride\Silicon\bundles\keycloak\Auth\Guard\KeycloakToken as KeycloakTokenGuard;
use Newride\Silicon\bundles\keycloak\Auth\UserProvider\Keycloak as KeycloakUserProvider;
use Newride\Silicon\bundles\keycloak\Contracts\AuthenticationReceiver as AuthenticationReceiverContract;
use Newride\Silicon\bundles\keycloak\Http\Middleware\CheckKeycloakRole as CheckKeycloakRoleMiddleware;
use Newride\Silicon\bundles\keycloak\Services\SimpleAuthenticationReceiver as AuthenticationReceiverImplementation;
use Newride\Silicon\bundles\keycloak\Classes\AuthenticatedUserContainer;
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
        $this->registerMiddlewares();
        $this->registerPolicies();
        $this->registerGuards();
        $this->registerGates();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/keycloak.php', 'keycloak');

        $this->app->singleton(Keycloak::class, function (): Keycloak {
            return new Keycloak(config('keycloak'));
        });
        $this->app->singleton(AuthenticatedUserContainer::class, function (): AuthenticatedUserContainer {
            return new AuthenticatedUserContainer();
        });

        $this->app->bind(
            AuthenticationReceiverContract::class,
            AuthenticationReceiverImplementation::class
        );
    }

    public function registerMiddlewares(): void
    {
        $router = $this->app->make('router');

        $router->aliasMiddleware('extension', CheckCanUseExtensionMiddleware::class);
        $router->aliasMiddleware('keycloak', CheckKeycloakRoleMiddleware::class);
    }

    public function registerGates(): void
    {
    }

    public function registerGuards(): void
    {
        Auth::extend('keycloak.session', function ($app, $name, array $config): KeycloakSessionGuard {
            return $app->make(KeycloakSessionGuard::class);
        });

        Auth::extend('keycloak.token', function ($app, $name, array $config): KeycloakTokenGuard {
            return $app->make(KeycloakTokenGuard::class);
        });

        Auth::provider('keycloak', function ($app, array $config): KeycloakUserProvider {
            return $app->make(KeycloakUserProvider::class);
        });
    }
}
