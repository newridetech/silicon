<?php

declare(strict_types=1);

namespace Newride\Laroak\bundles\keycloak\Auth\UserProvider;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Newride\Laroak\bundles\keycloak\User;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use pviojo\OAuth2\Client\Provider\Keycloak as KeycloakClient;

class Keycloak implements UserProvider
{
    public function __construct(KeycloakClient $keycloak)
    {
        $this->keycloak = $keycloak;
    }

    public function getAccessToken(string $code): AccessToken
    {
        return $this->keycloak->getAccessToken('authorization_code', [
            'code' => $code,
        ]);
    }

    public function retrieveById($identifier): ?Authenticatable
    {
        dd(__METHOD__);
    }

    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        dd(__METHOD__);
    }

    public function updateRememberToken(Authenticatable $user, $token): void
    {
        dd(__METHOD__);
    }

    public function retrieveByAccessToken(AccessToken $accessToken): ?Authenticatable
    {
        if (static::hasTokenExpired($accessToken)) {
            try {
                $accessToken = $this->keycloak->getAccessToken('refresh_token', [
                    'refresh_token' => $accessToken->getRefreshToken(),
                ]);
            } catch (IdentityProviderException $e) {
                // refresh token also expired
                return null;
            }
        }

        $resourceOwner = $this->keycloak->getResourceOwner($accessToken);

        return new User($resourceOwner, $accessToken);
    }

    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        $accessToken = $this->getAccessToken($credentials['code']);

        return $this->retrieveByAccessToken($accessToken);
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        $resourceOwner = $user->getKeycloakResourceOwner()->toArray();

        if (!array_key_exists('email_verified', $resourceOwner)) {
            // if that field is not set at all, we can assume that email
            // validation is disabled
            return true;
        }

        return boolval($resourceOwner['email_verified']);
    }

    protected static function hasTokenExpired(AccessToken $token): bool
    {
        return !empty($token->getExpires()) && $token->hasExpired();
    }
}
