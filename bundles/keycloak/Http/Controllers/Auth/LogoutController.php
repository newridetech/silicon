<?php

namespace Newride\Silicon\bundles\keycloak\Http\Controllers\Auth;

use Illuminate\Contracts\Auth\Guard;
use Newride\Silicon\bundles\keycloak\Http\Controllers\Auth as BaseController;
use pviojo\OAuth2\Client\Provider\Keycloak;

class LogoutController extends BaseController
{
    public $auth;

    public $keycloak;

    /**
     * Create a new controller instance.
     */
    public function __construct(Guard $auth, Keycloak $keycloak)
    {
        $this->auth = $auth;
        $this->keycloak = $keycloak;
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->auth->logout();

        return redirect()->route('frontend.home');
    }
}
