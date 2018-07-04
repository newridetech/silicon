<?php

namespace Newride\Laroak\app\Http\Controllers\Auth;

use Newride\Laroak\app\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use pviojo\OAuth2\Client\Provider\Keycloak;

class LogoutController extends Controller
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
