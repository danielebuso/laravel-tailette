<?php

namespace DanieleBuso\Tailette\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection generate(string $baseColor)
 * 
 * @see \DanieleBuso\Tailette\Tailette
 */
class Tailette extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tailette';
    }
}