<?php

namespace Newride\Silicon\bundles\extensions\Facades;

use Illuminate\Support\Facades\Facade;

class Extensions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'extensions';
    }
}
