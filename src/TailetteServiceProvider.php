<?php

namespace DanieleBuso\Tailette;

use Illuminate\Support\ServiceProvider;

class TailetteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register the main class to use with the facade
        $this->app->bind('tailette', function () {
            return new Tailette();
        });

        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../config/tailette.php', 'tailette'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../config/tailette.php' => config_path('tailette.php'),
        ], 'tailette-config');
    }
}