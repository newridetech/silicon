<?php

declare(strict_types=1);

namespace Newride\Silicon\bundles\keycloak\Classes;

use App;
use Illuminate\Http\Request;
use League\OAuth2\Client\Token\AccessToken;
use Newride\Silicon\bundles\keycloak\Contracts\KeycloakConnectionParametersHolder;
use pviojo\OAuth2\Client\Provider\Keycloak as KeycloakProvider;

class HttpClient implements KeycloakConnectionParametersHolder
{
    protected $authenticatedUserContainer;

    protected $connection;

    protected $provider;

    public function __construct(KeycloakConnectionParameters $connection, KeycloakProvider $provider, AuthenticatedUserContainer $authenticatedUserContainer)
    {
        $this->authenticatedUserContainer = $authenticatedUserContainer;
        $this->connection = $connection;
        $this->provider = $provider;
    }

    public function getAccessToken(): AccessToken
    {
        if (App::runningInConsole()) {
            return $this->provider->getAccessToken('client_credentials');
        }

        return $this->authenticatedUserContainer->getUser()->getAccessToken();
    }

    public function getKeycloakConnectionParameters(): KeycloakConnectionParameters
    {
        return $this->connection;
    }

    public function realm(string $method, $path, array $query = [], array $options = [])
    {
        $realm = $this->getKeycloakConnectionParameters()->getRealm();
        $path = '/admin/realms/'.$realm.$path;

        return $this->request($method, $path, $query, $options);
    }

    public function request(string $method, string $path, array $query = [], array $options = [])
    {
        $request = $this->provider->getAuthenticatedRequest(
            $method,
            HttpClientUrl::fromPath($this->connection, $path, $query)->getUrlWithParameters(),
            $this->getAccessToken(),
            $options
        );

        return $this->provider->getParsedResponse($request);
    }
}
