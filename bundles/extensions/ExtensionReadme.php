<?php

namespace Newride\Laroak\bundles\extensions;

use Parsedown;

class ExtensionReadme
{
    public $parsedown;

    public $path;

    public function __construct(string $path, Parsedown $parsedown)
    {
        $this->parsedown = $parsedown;
        $this->path = $path;
    }

    public function getContents(): string
    {
        return file_get_contents($this->path);
    }

    public function getTitle(): string
    {
        $file = fopen($this->path, 'r');
        $title = fgets($file);
        fclose($file);

        return trim($title, "# \n");
    }

    public function toHtml(): string
    {
        return $this->parsedown->text($this->getContents());
    }
}
