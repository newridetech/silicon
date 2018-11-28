<?php

namespace Newride\Silicon\bundles\keycloak\Http\Controllers\Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Session\Session;
use Newride\Silicon\bundles\keycloak\Contracts\AuthenticationReceiver;
use Newride\Silicon\bundles\keycloak\Http\Controllers\Auth as BaseController;
use pviojo\OAuth2\Client\Provider\Keycloak;

class CheckController extends BaseController
{
    public $authenticationReceiver;

    public $guard;

    public $keycloak;

    public $session;

    /**
     * Create a new controller instance.
     */
    public function __construct(AuthenticationReceiver $authenticationReceiver, Guard $guard, Keycloak $keycloak, Session $session)
    {
        $this->authenticationReceiver = $authenticationReceiver;
        $this->guard = $guard;
        $this->keycloak = $keycloak;
        $this->session = $session;
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $credentials = request()->only('state', 'session_state', 'code');

        if (!$this->guard->attempt($credentials)) {
            return $this
                ->authenticationReceiver
                ->getFailedAttemptResponse($this->guard, $credentials)
            ;
        }

        $url = $this->session->get('url.intended');
        if (!empty($url)) {
            return redirect($url);
        }

        return $this
            ->authenticationReceiver
            ->getIntendedUrlMissingResponse($this->guard, $credentials)
        ;
    }
}
