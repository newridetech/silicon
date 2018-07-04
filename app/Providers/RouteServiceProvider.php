<?php

namespace Newride\Laroak\app\Providers;

use Illuminate\Support\Facades\Route;
use Newride\Laroak\bundles\extensions\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Newride\\Laroak';
}
