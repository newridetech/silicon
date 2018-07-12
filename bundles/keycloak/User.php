<?php

namespace Newride\Silicon\bundles\keycloak;

use Illuminate\Foundation\Auth\Access\Authorizable;
use Newride\Silicon\bundles\keycloak\Contracts\OAuthUser;
use League\OAuth2\Client\Token\AccessToken;
use pviojo\OAuth2\Client\Provider\KeycloakResourceOwner;

class User implements OAuthUser
{
    use Authorizable;

    public $accessToken;

    public $keycloakResourceOwner;

    public function __construct(KeycloakResourceOwner $keycloakResourceOwner, AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
        $this->keycloakResourceOwner = $keycloakResourceOwner;
    }

    public function getAccessToken(): AccessToken
    {
        return $this->accessToken;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier(): string
    {
        return $this->keycloakResourceOwner->getId();
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName(): string
    {
        return 'sub';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword(): string
    {
        // nope
        return '';
    }

    public function getKeycloakResourceOwner(): KeycloakResourceOwner
    {
        return $this->keycloakResourceOwner;
    }

    public function getName(): string
    {
        return $this->keycloakResourceOwner->getName();
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken(): string
    {
        dd(__METHOD__);
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName(): string
    {
        dd(__METHOD__);
    }

    public function getUpdateProfileUrl(): string
    {
        return env('KEYCLOAK_AUTH_SERVER_URL').'/realms/master/account';
    }

    public function hasRole(string $role): bool
    {
        return $this->keycloakResourceOwner->hasRoleForClient(
            config('keycloak.clientId'), $role
        );
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value
     */
    public function setRememberToken($value): void
    {
        dd(__METHOD__);
    }
}
