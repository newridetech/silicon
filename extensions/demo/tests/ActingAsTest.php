<?php

namespace Newride\Silicon\extensions\demo\tests;

use Newride\Silicon\bundles\keycloak\tests\CreatesUser;
use Newride\Silicon\tests\TestCase;

class ActingAsTest extends TestCase
{
    use CreatesUser;

    public function testThatUserIsReplacedInBothKeycloakGuards()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get('api/v1/demo');
        $response->assertSuccessful();
        $response->assertJson([
            'message' => 'Hello, world!',
        ]);
    }
}
