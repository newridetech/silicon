<?php

namespace Newride\Laroak\bundles\extensions;

class ExtensionPath
{
    const NAMESPACE_SEPARATOR = '\\';

    public $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function basePath(string $filename): string
    {
        return $this->getExtensionDirectory().DIRECTORY_SEPARATOR.$filename;
    }

    public function getExtensionClass(string $namespace): string
    {
        $namespace = trim($namespace, self::NAMESPACE_SEPARATOR);
        $chunks = [$namespace, $this->getExtensionName(), 'Extension'];

        return implode(self::NAMESPACE_SEPARATOR, $chunks);
    }

    public function getExtensionDirectory(): string
    {
        return dirname($this->path);
    }

    public function getExtensionName(): string
    {
        $chunks = explode(DIRECTORY_SEPARATOR, $this->path);

        return head(array_slice($chunks, -2, 1));
    }
}
