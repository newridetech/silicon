<?php

namespace Newride\Silicon\bundles\keycloak\Http\Controllers\Auth;

use Newride\Silicon\bundles\keycloak\Http\Controllers\Auth as BaseController;

class RegisterController extends BaseController
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('page-auth-register');
    }
}
