<?php

declare(strict_types=1);

namespace Newride\Silicon\bundles\keycloak\Auth\Guard;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Newride\Silicon\bundles\keycloak\Auth\UserProvider\Keycloak as KeycloakUserProvider;
use Newride\Silicon\bundles\keycloak\Classes\AuthenticatedUserContainer;
use Newride\Silicon\bundles\keycloak\Classes\AuthorizationHeader;
use pviojo\OAuth2\Client\Provider\Keycloak as KeycloakClient;

class KeycloakToken implements Guard
{
    protected $keycloak;
    protected $provider;
    protected $userContainer;

    public function __construct(AuthenticatedUserContainer $userContainer, KeycloakClient $keycloak, KeycloakUserProvider $provider)
    {
        $this->keycloak = $keycloak;
        $this->provider = $provider;
        $this->userContainer = $userContainer;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check(): bool
    {
        return !is_null($this->user());
    }

    public function getAuthorizationHeader(): AuthorizationHeader
    {
        return AuthorizationHeader::fromRequest();
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest(): bool
    {
        return !$this->check();
    }

    public function id(): ?string
    {
        if ($this->user()) {
            return $this->user()->getAuthIdentifier();
        }

        return null;
    }

    public function setUser(Authenticatable $user): self
    {
        $this->userContainer->setUser($user);

        return $this;
    }

    public function user(): ?Authenticatable
    {
        if ($this->userContainer->hasUser()) {
            return $this->userContainer->getUser();
        }

        $accessToken = $this->getAuthorizationHeader()->getAccessToken();

        if (!$accessToken) {
            return null;
        }

        $user = $this->provider->retrieveByAccessToken($accessToken);

        if (empty($user)) {
            return null;
        }

        $this->setUser($user);

        return $this->userContainer->getUser();
    }

    public function validate(array $credentials = []): bool
    {
        return $this->getAuthorizationHeader()->hasAccessToken();
    }
}
