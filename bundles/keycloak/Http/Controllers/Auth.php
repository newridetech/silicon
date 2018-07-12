<?php

namespace Newride\Silicon\bundles\keycloak\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Auth extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
