<?php

namespace Newride\Silicon\bundles\keycloak\Contracts;

use League\OAuth2\Client\Token\AccessToken;

interface AccessTokenHolder
{
    public function getAccessToken(): AccessToken;
}
