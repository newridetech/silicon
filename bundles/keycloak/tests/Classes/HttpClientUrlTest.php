<?php

namespace Newride\Silicon\bundles\keycloak\tests\Classes;

use Newride\Silicon\bundles\keycloak\Classes\HttpClientUrl;
use Newride\Silicon\tests\TestCase;

class HttpClientTest extends TestCase
{
    public function testThatUrlWithParametersIsGenerated()
    {
        $httpClientUrl = HttpClientUrl::fromPath('/foo', [
            'limit' => 15,
        ]);

        $this->assertSame('https://keycloak/auth/foo?limit=15', $httpClientUrl->getUrlWithParameters());
    }
}
