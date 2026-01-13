<?php

namespace DarkDoom\HostSecurity\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DarkDoom\HostSecurity\HostSecurity
 */
class HostSecurity extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \DarkDoom\HostSecurity\HostSecurity::class;
    }
}
