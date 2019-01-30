<?php

namespace Newride\Silicon\bundles\keycloak;

use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Foundation\Auth\Access\Authorizable;
use League\OAuth2\Client\Token\AccessToken;
use Newride\Silicon\bundles\keycloak\Classes\KeycloakConnectionParameters;
use Newride\Silicon\bundles\keycloak\Contracts\OAuthUser;
use Newride\Silicon\bundles\keycloak\Exceptions\NotSupported;
use pviojo\OAuth2\Client\Provider\KeycloakResourceOwner;

class User implements OAuthUser
{
    use Authorizable;

    public $accessToken;

    public $connection;

    public $keycloakResourceOwner;

    public function __construct(KeycloakConnectionParameters $connection, KeycloakResourceOwner $keycloakResourceOwner, AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
        $this->connection = $connection;
        $this->keycloakResourceOwner = $keycloakResourceOwner;
    }

    public function __toString(): string
    {
        return $this->toJson();
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

    public function getKeycloakConnectionParameters(): KeycloakConnectionParameters
    {
        return $this->connection;
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
        throw NotSupported::stateless();
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName(): string
    {
        throw NotSupported::stateless();
    }

    public function getUpdateProfileUrl(): string
    {
        return env('KEYCLOAK_AUTH_SERVER_URL').'/realms/master/account';
    }

    public function getUsername(): string
    {
        $resourceOwner = $this->keycloakResourceOwner->toArray();

        return $resourceOwner['username']
            ?? $resourceOwner['preferred_username']
        ;
    }

    public function hasRole(string $role): bool
    {
        return $this->keycloakResourceOwner->hasRoleForClient(
            $this->connection->getClientId(),
            $role
        );
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value
     */
    public function setRememberToken($value): void
    {
        throw NotSupported::stateless();
    }

    public function toArray(): array
    {
        return [
            'accessToken' => $this->accessToken->jsonSerialize(),
            'keycloakResourceOwner' => $this->keycloakResourceOwner->toArray(),
        ];
    }

    public function toJson($options = 0): string
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }
}
