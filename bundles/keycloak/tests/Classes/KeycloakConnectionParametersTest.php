<?php

namespace Newride\Silicon\bundles\keycloak\tests\Classes;

use Newride\Silicon\bundles\keycloak\Classes\KeycloakConnectionParameters;
use Newride\Silicon\tests\TestCase;

class KeycloakConnectionParametersTest extends TestCase
{
    /**
     * @dataProvider validKeycloakConfigurationProvider
     */
    public function testThatParametersAreValidated(array $config)
    {
        $parameters = KeycloakConnectionParameters::fromArray($config);

        $this->assertSame($config['authServerUrl'], $parameters->getAuthServerUrl());
        $this->assertSame($config['clientId'], $parameters->getClientId());
        $this->assertSame($config['clientSecret'], $parameters->getClientSecret());
        $this->assertSame($config['encryptionAlgorithm'], $parameters->getEncryptionAlgorithm());
        $this->assertSame($config['encryptionKey'], $parameters->getEncryptionKey());
        $this->assertSame($config['encryptionKeyPath'], $parameters->getEncryptionKeyPath());
        $this->assertSame($config['realm'], $parameters->getRealm());
        $this->assertSame($config['redirectUri'], $parameters->getRedirectUri());

        $this->assertEquals($config, $parameters->toArray());
    }

    public function validKeycloakConfigurationProvider()
    {
        return [
            [
                [
                    'authServerUrl' => 'https://authServerUrl.example.com',
                    'clientId' => 'clientId',
                    'clientSecret' => 'clientSecret',
                    'encryptionAlgorithm' => 'encryptionAlgorithm',
                    'encryptionKey' => 'encryptionKey',
                    'encryptionKeyPath' => 'encryptionKeyPath',
                    'realm' => 'realm',
                    'redirectUri' => 'https://redirectUri.example.com',
                ],
            ],
        ];
    }
}
