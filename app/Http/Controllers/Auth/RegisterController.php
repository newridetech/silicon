<?php

namespace Newride\Laroak\app\Http\Controllers\Auth;

use Newride\Laroak\app\Http\Controllers\Controller;

class RegisterController extends Controller
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
