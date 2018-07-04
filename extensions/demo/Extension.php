<?php

namespace Newride\Laroak\extensions\demo;

use Newride\Laroak\bundles\extensions\Extension as BaseExtension;
use Newride\Laroak\bundles\keycloak\Contracts\OAuthUser;

class Extension extends BaseExtension
{
    public function canUseAnonymous(): bool
    {
        return true;
    }
}
