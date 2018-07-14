<?php

namespace Newride\Silicon\bundles\keycloak\tests;

use Illuminate\Support\Str;
use Newride\Silicon\bundles\keycloak\User;
use League\OAuth2\Client\Token\AccessToken;
use pviojo\OAuth2\Client\Provider\KeycloakResourceOwner;

trait CreatesUser
{
    public function createUser(array $roles = [])
    {
        return new User(
            new KeycloakResourceOwner([
                'roles' => [
                    config('keycloak.clientId') => [
                        'roles' => $roles,
                    ],
                ],
                'sub' => Str::uuid()->toString(),
            ]),
            new AccessToken([
                'access_token' => uniqid(),
            ])
        );
    }
}
