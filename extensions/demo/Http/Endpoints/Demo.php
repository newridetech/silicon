<?php

namespace Newride\Laroak\extensions\demo\Http\Endpoints;

use Newride\Laroak\app\Http\Controllers\Controller;

class Demo extends Controller
{
    public function index()
    {
        return view('extensions.demo::page-demo');
    }
}
