<?php

declare(strict_types=1);

namespace Newride\Silicon\bundles\keycloak\Auth\Guard;

use Newride\Silicon\bundles\keycloak\Classes\AuthorizationHeader;
use Newride\Silicon\bundles\keycloak\Auth\UserProvider\Keycloak as KeycloakUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use pviojo\OAuth2\Client\Provider\Keycloak as KeycloakClient;

class KeycloakToken implements Guard
{
    protected $keycloak;
    protected $user;
    protected $provider;

    public function __construct(KeycloakClient $keycloak, KeycloakUserProvider $provider)
    {
        $this->keycloak = $keycloak;
        $this->provider = $provider;
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

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest(): bool
    {
        return !$this->check();
    }

    public function user(): ?Authenticatable
    {
        if ($this->user) {
            return $this->user;
        }

        $accessToken = AuthorizationHeader::fromRequest()->getAccessToken();

        if (!$accessToken) {
            return null;
        }

        $user = $this->provider->retrieveByAccessToken($accessToken);

        if (empty($user)) {
            return null;
        }

        $this->setUser($user);

        return $this->user;
    }

    public function id(): ?string
    {
        if ($this->user()) {
            return $this->user()->getAuthIdentifier();
        }

        return null;
    }

    public function validate(array $credentials = []): bool
    {
        return AuthorizationHeader::fromRequest()->hasAccessToken();
    }

    public function setUser(Authenticatable $user): self
    {
        $this->user = $user;

        return $this;
    }
}
