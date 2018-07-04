<?php

namespace Newride\Laroak\bundles\keycloak\Contracts;

use Illuminate\Contracts\Auth\Guard;
use use Symfony\Component\HttpFoundation\Response;

interface AuthenticationReceiver
{
    function getFailedAttemptResponse(Guard $guard, array $credentials): Response;

    function getIntendedUrlMissingResponse(Guard $guard, array $credentials): Response;
}
