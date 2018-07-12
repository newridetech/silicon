<?php

namespace Newride\Silicon\bundles\extensions\Http\Middleware;

use Auth;
use Closure;
use Extensions;
use Illuminate\Auth\AuthenticationException;
use Newride\Silicon\bundles\extensions\Exceptions\Unauthorized\CannotUseExtension;

class CheckCanUseExtension
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, string $extension)
    {
        $user = Auth::user();

        if ($user) {
            if (!Extensions::canUse($extension, $user)) {
                throw new CannotUseExtension($extension);
            }
        } else {
            if (!Extensions::canUseAnonymous($extension)) {
                throw new AuthenticationException(sprintf('Extension "%s" cannot be used by anonymous user.', $extension));
            }
        }

        return $next($request);
    }
}
