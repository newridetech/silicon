<?php

namespace Newride\Silicon\extensions\demo;

use Newride\Silicon\bundles\extensions\Extension as BaseExtension;

class Extension extends BaseExtension
{
    public function canUseAnonymous(): bool
    {
        return false;
    }
}
