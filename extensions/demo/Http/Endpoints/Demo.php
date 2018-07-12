<?php

namespace Newride\Silicon\extensions\demo\Http\Endpoints;

use Newride\Silicon\app\Http\Controllers\Controller;

class Demo extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Hello, world!',
        ]);
    }
}
