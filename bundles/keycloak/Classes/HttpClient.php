<?php

declare(strict_types=1);

namespace Newride\Silicon\bundles\keycloak\Classes;

use Illuminate\Http\Request;
use League\OAuth2\Client\Token\AccessToken;
use pviojo\OAuth2\Client\Provider\Keycloak as KeycloakProvider;

class Keycloak
{
    public function __construct(KeycloakProvider $provider, AuthenticatedUserContainer $authenticatedUserContainer)
    {
        $this->authenticatedUserContainer = $authenticatedUserContainer;
        $this->provider = $provider;
    }

    public function getAccessToken(): AccessToken
    {
        return $this->authenticatedUserContainer->getUser()->getAccessToken();
    }

    public function request(string $method, string $path, array $parameters = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            $method,
            HttpClientUrl::fromPath($path, $parameters)->getUrlWithParameters(),
            $this->getAccessToken()
        );

        return $this->provider->getParsedResponse($request);
    }
}
