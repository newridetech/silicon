<?php

namespace Newride\Silicon\bundles\keycloak\Services;

use Illuminate\Contracts\Auth\Guard;
use Newride\Silicon\bundles\keycloak\Contracts\AuthenticationReceiver;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class SimpleAuthenticationReceiver implements AuthenticationReceiver
{
    public function getFailedAttemptResponse(Guard $guard, array $credentials): Response
    {
        return new RedirectResponse('/');
    }

    public function getIntendedUrlMissingResponse(Guard $guard, array $credentials): Response
    {
        return new RedirectResponse('/');
    }
}
