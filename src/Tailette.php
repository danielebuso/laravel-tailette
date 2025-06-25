<?php

namespace DanieleBuso\Tailette;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Tailette
{
    /**
     * Generate a color palette with caching support
     */
    public static function generate(string $baseColor): Collection
    {
        $instance = new self;

        // Normalize the base color (remove # if present)
        $baseColor = ltrim($baseColor, '#');

        // Get cache duration from config
        $cacheDuration = config('tailette.cache_duration');

        // If caching is disabled, generate the palette without caching
        if ($cacheDuration === null) {
            return $instance->generateColorPalette($baseColor);
        }

        // Generate the palette with caching
        $cacheKey = 'tailette_palette_' . $baseColor;

        return Cache::remember($cacheKey, $cacheDuration, function () use ($instance, $baseColor) {
            return $instance->generateColorPalette($baseColor);
        });
    }

    /**
     * Generate a color palette without using cache (for testing)
     */
    public static function generatePalette(string $baseColor): Collection
    {
        $instance = new self;

        // Normalize the base color (remove # if present)
        $baseColor = ltrim($baseColor, '#');

        // Generate the color palette locally
        return $instance->generateColorPalette($baseColor);
    }

    /**
     * Generate a color palette based on a base color
     *
     * @param  string  $baseColor  Hex color without #
     */
    private function generateColorPalette(string $baseColor): Collection
    {
        // If the base color is not a valid hex color, return the default blue palette
        if (! preg_match('/^[0-9A-F]{6}$/i', $baseColor)) {
            return $this->getDefaultPalette();
        }

        // Convert hex to RGB
        $r = hexdec(substr($baseColor, 0, 2));
        $g = hexdec(substr($baseColor, 2, 2));
        $b = hexdec(substr($baseColor, 4, 2));

        // Generate the palette
        $palette = [
            '50' => $this->lighten([$r, $g, $b], 0.95),
            '100' => $this->lighten([$r, $g, $b], 0.9),
            '200' => $this->lighten([$r, $g, $b], 0.75),
            '300' => $this->lighten([$r, $g, $b], 0.6),
            '400' => $this->lighten([$r, $g, $b], 0.3),
            '500' => $this->rgbToHex($r, $g, $b),
            '600' => $this->darken([$r, $g, $b], 0.1),
            '700' => $this->darken([$r, $g, $b], 0.2),
            '800' => $this->darken([$r, $g, $b], 0.3),
            '900' => $this->darken([$r, $g, $b], 0.4),
            '950' => $this->darken([$r, $g, $b], 0.5),
        ];

        return collect($palette);
    }

    /**
     * Lighten a color by a given amount
     *
     * @param  array  $rgb  RGB color values
     * @param  float  $amount  Amount to lighten (0-1)
     * @return string Hex color
     */
    private function lighten(array $rgb, float $amount): string
    {
        $r = $rgb[0];
        $g = $rgb[1];
        $b = $rgb[2];

        $r = (int) ($r + (255 - $r) * $amount);
        $g = (int) ($g + (255 - $g) * $amount);
        $b = (int) ($b + (255 - $b) * $amount);

        return $this->rgbToHex($r, $g, $b);
    }

    /**
     * Darken a color by a given amount
     *
     * @param  array  $rgb  RGB color values
     * @param  float  $amount  Amount to darken (0-1)
     * @return string Hex color
     */
    private function darken(array $rgb, float $amount): string
    {
        $r = $rgb[0];
        $g = $rgb[1];
        $b = $rgb[2];

        $r = (int) ($r * (1 - $amount));
        $g = (int) ($g * (1 - $amount));
        $b = (int) ($b * (1 - $amount));

        return $this->rgbToHex($r, $g, $b);
    }

    /**
     * Convert RGB values to a hex color
     *
     * @param  int  $r  Red (0-255)
     * @param  int  $g  Green (0-255)
     * @param  int  $b  Blue (0-255)
     * @return string Hex color
     */
    private function rgbToHex(int $r, int $g, int $b): string
    {
        return '#'.sprintf('%02x%02x%02x', $r, $g, $b);
    }

    /**
     * Get the default color palette from config
     */
    private function getDefaultPalette(): Collection
    {
        return collect(config('tailette.default_palette', [
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
        ]));
    }
}
