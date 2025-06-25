<?php

use DanieleBuso\Tailette\Facades\Tailette;

it('generates a color palette from a valid hex color', function () {
    $palette = Tailette::generate('1aa34d');

    expect($palette)->toHaveCount(11)
        ->and($palette->toArray())->toHaveKey('50')
        ->and($palette->toArray())->toHaveKey('500')
        ->and($palette->toArray())->toHaveKey('950')
        ->and($palette['500'])->toBe('#1aa34d');

    // The 500 shade should be the original color
});

it('returns default palette for invalid hex color', function () {
    $palette = Tailette::generate('invalid');

    expect($palette)->toHaveCount(11)
        ->and($palette['500'])->toBe('#3b82f6');
    // Default blue
});

it('generates palette without cache', function () {
    $palette = Tailette::generatePalette('1aa34d');

    expect($palette)->toHaveCount(11)
        ->and($palette['500'])->toBe('#1aa34d');
});

it('handles hex colors with hash prefix', function () {
    $palette = Tailette::generate('#1aa34d');

    expect($palette)->toHaveCount(11)
        ->and($palette['500'])->toBe('#1aa34d');
});
