<?php

namespace Newride\Silicon\bundles\keycloak\Exceptions\Unauthorized;

use Exception;
use Newride\Silicon\bundles\keycloak\Exceptions\Unauthorized;

class RoleRequired extends Unauthorized
{
    public function __construct(string $role, int $code = 0, Exception $previous = null)
    {
        parent::__construct(
            sprintf('Viewing this page requires "%s" client role.', $role),
            $code,
            $previous
        );
    }
}
