<?php

namespace Newride\Laroak\extensions\demo;

use Newride\Laroak\bundles\extensions\Extension as BaseExtension;

class Extension extends BaseExtension
{
    public function canUseAnonymous(): bool
    {
        return false;
    }
}
