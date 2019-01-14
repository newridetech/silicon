<?php

declare(strict_types=1);

namespace Newride\Silicon\bundles\keycloak\Classes;

use App;
use Illuminate\Http\Request;
use League\OAuth2\Client\Token\AccessToken;
use pviojo\OAuth2\Client\Provider\Keycloak as KeycloakProvider;

class HttpClient
{
    public function __construct(KeycloakProvider $provider, AuthenticatedUserContainer $authenticatedUserContainer)
    {
        $this->authenticatedUserContainer = $authenticatedUserContainer;
        $this->provider = $provider;
    }

    public function getAccessToken(): AccessToken
    {
        if (App::runningInConsole()) {
            return $this->provider->getAccessToken('client_credentials');
        }

        return $this->authenticatedUserContainer->getUser()->getAccessToken();
    }

    public function realm(string $method, $path, array $query = [], array $options = [])
    {
        $path = '/admin/realms/'.config('keycloak.realm').$path;

        return $this->request($method, $path, $query, $options);
    }

    public function request(string $method, string $path, array $query = [], array $options = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            $method,
            HttpClientUrl::fromPath($path, $query)->getUrlWithParameters(),
            $this->getAccessToken(),
            $options
        );

        return $this->provider->getParsedResponse($request);
    }
}
