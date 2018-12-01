<?php

namespace Newride\Silicon\bundles\keycloak\Exceptions\Keycloak\Authorization;

use Newride\Silicon\bundles\keycloak\Exceptions\Keycloak\Authorization;

class Roles extends Authorization
{
    public function __construct(string $client, array $roles, string $action)
    {
        return parent::__construct(sprintf('You need "%s" client roles: %s to %s.', $client, json_encode($roles), $action));
    }
}
