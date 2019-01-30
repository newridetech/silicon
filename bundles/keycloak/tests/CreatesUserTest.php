<?php

namespace Newride\Silicon\bundles\keycloak\tests;

use Newride\Silicon\tests\TestCase;

class CreatesUserTest extends TestCase
{
    use CreatesUser;

    public function testThatUserIsCreated()
    {
        $user = $this->createUser([
            'manage-bar',
            'view-foo',
        ]);

        $this->assertTrue($user->hasRole('manage-bar'));
        $this->assertTrue($user->hasRole('view-foo'));
    }
}
