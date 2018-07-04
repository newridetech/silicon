<?php

namespace Newride\Laroak\extensions\demo\Http\Controllers;

use Newride\Laroak\app\Http\Controllers\Controller;

class Demo extends Controller
{
    public function index()
    {
        return view('page-demo');
    }
}
