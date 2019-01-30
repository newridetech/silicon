<?php

namespace Newride\Silicon\bundles\keycloak\Classes\AccessTokenGranter;

use Newride\Silicon\bundles\keycloak\Classes\AccessTokenGranter;
use Newride\Silicon\bundles\keycloak\Classes\AuthenticatedUserContainer;

class AuthorizationCode extends AccessTokenGranter
{
    protected $authenticatedUserContainer;

    public function __construct(AuthenticatedUserContainer $authenticatedUserContainer)
    {
        $this->authenticatedUserContainer = $authenticatedUserContainer;
    }

    public function getAccessToken(): AccessToken
    {
        return $this->authenticatedUserContainer->getUser()->getAccessToken();
    }
}
