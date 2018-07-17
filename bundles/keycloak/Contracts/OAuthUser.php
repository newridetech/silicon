<?php

namespace Newride\Silicon\bundles\keycloak\Contracts;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

interface OAuthUser extends Arrayable, Authenticatable, Authorizable, Jsonable, JsonSerializable
{
    public function getName(): string;

    public function getUpdateProfileUrl(): string;

    public function getUsername(): ?string;

    public function hasRole(string $role): bool;
}
