<?php

namespace Newride\Silicon\bundles\keycloak\Contracts;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;

interface OAuthUser extends Authenticatable, Authorizable
{
    public function getName(): string;

    public function getUpdateProfileUrl(): string;

    public function hasRole(string $role): bool;
}
