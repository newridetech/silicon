<?php

namespace Newride\Silicon\bundles\keycloak\Contracts;

use Illuminate\Contracts\Auth\Guard;
use Symfony\Component\HttpFoundation\Response;

interface AuthenticationReceiver
{
    public function getFailedAttemptResponse(Guard $guard, array $credentials): Response;

    public function getIntendedUrlMissingResponse(Guard $guard, array $credentials): Response;
}
