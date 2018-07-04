<?php

namespace Newride\Laroak\bundles\extensions;

use Illuminate\Foundation\Application;
use Newride\Laroak\bundles\keycloak\Contracts\OAuthUser;

abstract class Extension
{
    protected $app;

    protected $extensionPath;

    public function __construct(Application $app, ExtensionPath $extensionPath)
    {
        $this->app = $app;
        $this->extensionPath = $extensionPath;
    }

    public function boot(): void
    {
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

    public function register(): void
    {
    }
}
