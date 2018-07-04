<?php

namespace Newride\Laroak\app\Http\Controllers\Auth;

use Illuminate\Contracts\Session\Session;
use Newride\Laroak\app\Http\Controllers\Controller;
use pviojo\OAuth2\Client\Provider\Keycloak;

class LoginController extends Controller
{
    public $keycloak;

    public $session;

    /**
     * Create a new controller instance.
     */
    public function __construct(Keycloak $keycloak, Session $session)
    {
        $this->keycloak = $keycloak;
        $this->session = $session;

        // $this->middleware('guest');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authorizationUrl = $this->keycloak->getAuthorizationUrl();

        $this->session->put('keycloak_provider_state', $this->keycloak->getState());

        return redirect($authorizationUrl);
    }
}
