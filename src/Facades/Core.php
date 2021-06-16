<?php

namespace Akizor\Scaffold\Facades;

use Illuminate\Support\Facades\Facade;

class Scaffold extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'scaffold';
    }
}
