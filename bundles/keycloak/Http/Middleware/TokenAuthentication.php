<?php

namespace Newride\Silicon\bundles\keycloak\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Newride\Silicon\bundles\keycloak\Exceptions\Unauthorized\RoleRequired;

class TokenAuthentication
{
    public $guard;

    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        dd($this->guard);
        // throw new RoleRequired($role);
    }
}
