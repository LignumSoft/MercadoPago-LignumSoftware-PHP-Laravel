<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MP extends Facade
{
    protected static function getFacadeAccessor()
    {
        //le pones el nombre con el que va a ser llamad ala facade
        return 'MP';
    }
}