<?php

namespace Newride\Silicon\bundles\keycloak\tests\Classes;

use Newride\Silicon\bundles\keycloak\Classes\HttpClientUrl;
use Newride\Silicon\bundles\keycloak\Classes\KeycloakConnectionParameters;
use Newride\Silicon\tests\TestCase;

class HttpClientTest extends TestCase
{
    public function testThatUrlWithParametersIsGenerated()
    {
        $connection = KeycloakConnectionParameters::fromArray([
            'authServerUrl' => 'https://authServerUrl.example.com',
            'clientId' => 'clientId',
            'clientSecret' => 'clientSecret',
            'encryptionAlgorithm' => 'encryptionAlgorithm',
            'encryptionKey' => 'encryptionKey',
            'encryptionKeyPath' => 'encryptionKeyPath',
            'realm' => 'realm',
            'redirectUri' => 'https://redirectUri.example.com',
        ]);
        $httpClientUrl = HttpClientUrl::fromPath($connection, '/foo', [
            'limit' => 15,
        ]);

        $this->assertSame('https://authserverurl.example.com/foo?limit=15', $httpClientUrl->getUrlWithParameters());
    }
}
