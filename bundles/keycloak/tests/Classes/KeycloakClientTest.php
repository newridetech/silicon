<?php

namespace Newride\Silicon\bundles\keycloak\tests\Classes;

use Newride\Silicon\bundles\keycloak\Classes\KeycloakClient;
use Newride\Silicon\tests\TestCase;

class KeycloakClientTest extends TestCase
{
    public function testThatUrlWithParametersIsGenerated()
    {
        $keycloakClient = app(KeycloakClient::class);

        // at least check if object is constructed
        $this->assertInstanceOf(KeycloakClient::class, $keycloakClient);
    }
}
