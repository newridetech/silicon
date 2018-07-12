<?php

namespace Newride\Silicon\tests\Feature;

use Newride\Silicon\tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        // keycloak redirect
        $response->assertStatus(302);
    }
}
