<?php

declare(strict_types=1);

namespace Newride\Silicon\bundles\keycloak\Classes;

use Illuminate\Contracts\Auth\Authenticatable;

class AuthenticatedUserContainer
{
    protected $user;

    public function getUser(): Authenticatable
    {
        return $this->user;
    }

    public function hasUser(): bool
    {
        return !is_null($this->user);
    }

    public function removeUser(): void
    {
        $this->user = null;
    }

    public function setUser(Authenticatable $user): void
    {
        $this->user = $user;
    }
}
