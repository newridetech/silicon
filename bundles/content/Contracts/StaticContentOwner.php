<?php

namespace Newride\Laroak\bundles\content\Contracts;

interface StaticContentOwner
{
    public function content(string $locale): StaticContent;
}
