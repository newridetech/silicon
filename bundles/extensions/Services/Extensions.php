<?php

namespace Newride\Laroak\bundles\extensions\Services;

use Newride\Laroak\bundles\extensions\Extension;
use Newride\Laroak\bundles\extensions\ExtensionPath;
use Newride\Laroak\bundles\keycloak\Contracts\OAuthUser;
use Illuminate\Foundation\Application;
use LogicException;
use RuntimeException;
use Webmozart\Glob\Iterator\GlobIterator;

class Extensions
{
    protected $app;

    protected $extensions = null;

    protected $namespace;

    public function __construct(Application $app, string $namespace = null)
    {
        $this->app = $app;
        $this->namespace = config('laroak.base_namespace', $namespace).'extensions\\';
    }

    public function all(): iterable
    {
        yield from $this->getExtensions();
    }

    public function canUse(string $name, OAuthUser $user = null): bool
    {
        if (is_null($user)) {
            return $this->canUseWithoutUser($name);
        }

        return $this->isLoaded($name) && $this->get($name)->canUse($user);
    }

    public function canUseAnonymous(string $name): bool
    {
        return $this->isLoaded($name) && $this->get($name)->canUseAnonymous();
    }

    /**
     * Having no user set may be a different case than an anonymous usage.
     * Laroak framework user may be using
     * Extensions::canUse($name, Auth::user()) or blade @extension() directive
     * to check if a given user is liable to use an extension. Auth::user()
     * may return null though, so expectations may be different. This function
     * exists just in case but falls back to anonymous user by default.
     */
    public function canUseWithoutUser(string $name): bool
    {
        return $this->canUseAnonymous($name);
    }

    public function get(string $name): Extension
    {
        if (!$this->isLoaded($name)) {
            throw new RuntimeException(sprintf('Extensions "%s" is not loaded.', $name));
        }

        return $this->getExtensions()[$name];
    }

    public function getBaseNamespace(): string
    {
        return $this->namespace;
    }

    public function isLoaded(string $name): bool
    {
        return array_key_exists($name, $this->getExtensions());
    }

    public function preload(): void
    {
        $this->extensions = [];
        $glob = base_path('extensions/*/Extension.php');

        foreach (new GlobIterator($glob) as $path) {
            $extensionPath = new ExtensionPath($path);
            $extensionClass = $extensionPath->getExtensionClass($this->namespace);

            $this->extensions[$extensionPath->getExtensionName()] = $this->app->makeWith($extensionClass, [
                'extensionPath' => $extensionPath,
            ]);
        }
    }

    public function routes(string $type): iterable
    {
        foreach ($this->all() as $extension) {
            $filename = $extension->getPath()->basePath('routes/'.$type.'.php');
            if (file_exists($filename)) {
                yield $extension->getName() => $filename;
            }
        }
    }

    public function user(OAuthUser $user): iterable
    {
        foreach ($this->all() as $extension) {
            if ($extension->canUse($user)) {
                yield $extension;
            }
        }
    }

    protected function getExtensions(): array
    {
        if (is_null($this->extensions)) {
            throw new LogicException(sprintf('Use %s::preload first to cache extensions.', __CLASS__));
        }

        return $this->extensions;
    }
}
