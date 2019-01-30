<?php

namespace Newride\Silicon\bundles\keycloak\tests;

use Illuminate\Support\Str;
use League\OAuth2\Client\Token\AccessToken;
use Newride\Silicon\bundles\keycloak\Classes\KeycloakConnectionParameters;
use Newride\Silicon\bundles\keycloak\User;
use pviojo\OAuth2\Client\Provider\KeycloakResourceOwner;

trait CreatesUser
{
    public function createUser(array $roles = [], string $username = null): User
    {
        return new User(
            KeycloakConnectionParameters::fromArray([
                'authServerUrl' => 'https://authServerUrl.example.com',
                'clientId' => 'mockup.client',
                'clientSecret' => 'clientSecret',
                'encryptionAlgorithm' => 'encryptionAlgorithm',
                'encryptionKey' => 'encryptionKey',
                'encryptionKeyPath' => 'encryptionKeyPath',
                'realm' => 'realm',
                'redirectUri' => 'https://redirectUri.example.com',
            ]),
            new KeycloakResourceOwner([
                'roles' => [
                    'mockup.client' => [
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
