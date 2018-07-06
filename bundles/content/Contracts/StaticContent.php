<?php

namespace Newride\Laroak\bundles\content\Contracts;

interface StaticContent
{
    public function get(string $field, string $fallback = null): string;

    public function has(string $field): bool;

    public function isLocale(string $locale): bool;

    public function setOwner(StaticContentOwner $owner): void;
}
