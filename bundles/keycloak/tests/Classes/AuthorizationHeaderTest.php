<?php

namespace Newride\Laroak\keycloak\extensions;

use Newride\Laroak\bundles\keycloak\Classes\AuthorizationHeader;
use PHPUnit\Framework\TestCase;

class AuthorizationHeaderTest extends TestCase
{
    public function testThatBearerIsExtracted()
    {
        $authHeader = new AuthorizationHeader('Bearer foo');

        $this->assertTrue($authHeader->hasAccessToken());
        $this->assertSame('foo', $authHeader->getBearer());
    }

    public function testThatAccessTokenIsExtracted()
    {
        $authHeader = new AuthorizationHeader('Bearer foo');

        $this->assertTrue($authHeader->hasAccessToken());
        $this->assertSame('foo', $authHeader->getAccessToken()->getToken());
    }

    public function testThatDeterminesIfAccessTokenIsPresent()
    {
        $authHeader = new AuthorizationHeader('Bearer');

        $this->assertFalse($authHeader->hasAccessToken());
    }
}
