<?php

namespace Newride\Silicon\bundles\keycloak\Classes\AccessTokenGranter;

use League\OAuth2\Client\Token\AccessToken;
use Newride\Silicon\bundles\keycloak\Classes\AccessTokenGranter;
use pviojo\OAuth2\Client\Provider\Keycloak as KeycloakProvider;

class ClientCredentials extends AccessTokenGranter
{
    protected $provider;

    public function __construct(KeycloakProvider $provider)
    {
        $this->provider = $provider;
    }

    public function getAccessToken(): AccessToken
    {
        return $this->provider->getAccessToken('client_credentials');
    }
}
