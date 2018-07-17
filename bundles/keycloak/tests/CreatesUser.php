<?php

namespace Newride\Silicon\bundles\keycloak\tests;

use Illuminate\Support\Str;
use Newride\Silicon\bundles\keycloak\User;
use League\OAuth2\Client\Token\AccessToken;
use pviojo\OAuth2\Client\Provider\KeycloakResourceOwner;

trait CreatesUser
{
    public function createUser(array $roles = [], string $username = null): User
    {
        return new User(
            new KeycloakResourceOwner([
                'roles' => [
                    config('keycloak.clientId') => [
                        'roles' => $roles,
                    ],
                ],
                'sub' => Str::uuid()->toString(),
                'preferred_username' => $username ?: uniqid(),
            ]),
            new AccessToken([
                'access_token' => uniqid(),
            ])
        );
    }
}
