<?php

namespace Newride\Silicon\bundles\keycloak\Http\Middleware;

use Closure;
use Newride\Silicon\bundles\keycloak\Exceptions\Unauthorized\RoleRequired;

class CheckKeycloakRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, string $role)
    {
        if ($request->user()->hasRole($role)) {
            return $next($request);
        }

        throw new RoleRequired($role);
    }
}
