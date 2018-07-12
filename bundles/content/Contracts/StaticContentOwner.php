<?php

namespace Newride\Silicon\bundles\content\Contracts;

interface StaticContentOwner
{
    public function content(string $locale): StaticContent;
}
