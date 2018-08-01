<?php

namespace Newride\Silicon\bundles\keycloak\tests;

use Newride\Silicon\tests\TestCase;

class UserTest extends TestCase
{
    use CreatesUser;

    public function testThatUserIsSerializable()
    {
        $user = $this->createUser();

        $this->assertEquals($user, unserialize(serialize($user)));
    }

    public function testThatUserCanBeConvertedToString()
    {
        $user = $this->createUser();

        $this->assertNotNull(json_decode(json_encode($user)));
    }
}
