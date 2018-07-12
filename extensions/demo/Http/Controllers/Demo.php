<?php

namespace Newride\Silicon\extensions\demo\Http\Controllers;

use Newride\Silicon\app\Http\Controllers\Controller;

class Demo extends Controller
{
    public function index()
    {
        return view('extensions.demo::page-demo');
    }
}
