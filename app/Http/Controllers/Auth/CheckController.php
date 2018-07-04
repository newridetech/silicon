<?php

namespace Newride\Laroak\app\Http\Controllers\Auth;

use Newride\Laroak\app\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Session\Session;
use pviojo\OAuth2\Client\Provider\Keycloak;

class CheckController extends Controller
{
    public $guard;

    public $keycloak;

    public $session;

    /**
     * Create a new controller instance.
     */
    public function __construct(Guard $guard, Keycloak $keycloak, Session $session)
    {
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
            return ':(';
        }

        $url = $this->session->get('url.intended');
        if (!empty($url)) {
            return redirect($url);
        }

        return redirect()->route('frontend.home');
    }
}
