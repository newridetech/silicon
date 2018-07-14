<?php

namespace Newride\Silicon\bundles\extensions;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Newride\Silicon\bundles\keycloak\Contracts\OAuthUser;

abstract class Extension extends AuthServiceProvider
{
    protected $extensionPath;

    public function __construct(Application $app, ExtensionPath $extensionPath)
    {
        parent::__construct($app);

        $this->extensionPath = $extensionPath;
    }

    public function boot(): void
    {
        $this->loadMigrations();
        $this->loadTranslations();
        $this->loadViews();
        $this->registerPolicies();
    }

    public function canUseAnonymous(): bool
    {
        return false;
    }

    public function canUse(OAuthUser $user): bool
    {
        return true;
    }

    public function dependencies(): iterable
    {
        return [];
    }

    public function getName(): string
    {
        return $this->getPath()->getExtensionName();
    }

    public function getPath(): ExtensionPath
    {
        return $this->extensionPath;
    }

    public function getReadme(): ExtensionReadme
    {
        return $this->app->makeWith(ExtensionReadme::class, [
            'path' => $this->getPath()->basePath('README.md'),
        ]);
    }

    public function getServiceNamespace(): string
    {
        return 'extensions.'.$this->getName();
    }

    public function getMigrationsDirectory(): string
    {
        return $this->extensionPath->basePath('migrations');
    }

    public function getTranslationsDirectory(): string
    {
        return $this->extensionPath->basePath('lang');
    }

    public function getViewsDirectory(): string
    {
        return $this->extensionPath->basePath('views');
    }

    public function loadMigrations(): void
    {
        $this->loadMigrationsFrom($this->getMigrationsDirectory());
    }

    public function loadTranslations(): void
    {
        $this->loadTranslationsFrom(
            $this->getTranslationsDirectory(),
            $this->getServiceNamespace()
        );
    }

    public function loadViews(): void
    {
        $this->loadViewsFrom(
            $this->getViewsDirectory(),
            $this->getServiceNamespace()
        );
    }

    public function register(): void
    {
    }
}
