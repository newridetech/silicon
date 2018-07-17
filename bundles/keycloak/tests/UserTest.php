<?php

namespace Newride\Silicon\bundles\keycloak\tests;

use Illuminate\Support\Str;
use Newride\Silicon\bundles\keycloak\User;
use Newride\Silicon\tests\TestCase;
use League\OAuth2\Client\Token\AccessToken;
use pviojo\OAuth2\Client\Provider\KeycloakResourceOwner;

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
