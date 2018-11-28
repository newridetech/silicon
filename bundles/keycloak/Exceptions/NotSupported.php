<?php

namespace Newride\Silicon\bundles\keycloak\Exceptions;

use LogicException;

abstract class NotSupported extends LogicException
{
    public static function authenticationWithoutCredentials(): self
    {
        return new self('It is not possible to force authentication without providing valid credentials.');
    }

    public static function stateless(): self
    {
        return new self('It is not possible to force stateless authentication or authenticate without providing valid credentials.');
    }
}
