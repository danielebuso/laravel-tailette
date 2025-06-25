<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Color Palette
    |--------------------------------------------------------------------------
    |
    | This is the default color palette that will be used when an invalid
    | color is provided or when no color is specified.
    |
    */
    'default_palette' => [
        '50' => '#eff6ff',
        '100' => '#dbeafe',
        '200' => '#bfdbfe',
        '300' => '#93c5fd',
        '400' => '#60a5fa',
        '500' => '#3b82f6',
        '600' => '#2563eb',
        '700' => '#1d4ed8',
        '800' => '#1e40af',
        '900' => '#1e3a8a',
        '950' => '#172554',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Duration
    |--------------------------------------------------------------------------
    |
    | The number of minutes to cache generated color palettes. Set to null
    | to disable caching.
    |
    */
    'cache_duration' => 60 * 24, // 1 day
];