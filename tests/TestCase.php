<?php

namespace DanieleBuso\Tailette\Tests;

use DanieleBuso\Tailette\Facades\Tailette;
use DanieleBuso\Tailette\TailetteServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [TailetteServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Tailette' => Tailette::class,
        ];
    }
}