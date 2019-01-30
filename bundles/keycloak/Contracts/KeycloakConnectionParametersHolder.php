<?php

namespace Newride\Silicon\bundles\keycloak\Contracts;

use Newride\Silicon\bundles\keycloak\Classes\KeycloakConnectionParameters;

interface KeycloakConnectionParametersHolder
{
    public function getKeycloakConnectionParameters(): KeycloakConnectionParameters;
}
