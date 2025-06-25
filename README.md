# Laravel Tailette

A Laravel package for generating Tailwind CSS color palettes from a base color.

## Installation

You can install the package via composer:

```bash
composer require danielebuso/laravel-tailette
```

The package will automatically register its service provider if you're using Laravel >= 5.5 with package auto-discovery.

## Publishing the config file

You can publish the config file with:

```bash
php artisan vendor:publish --tag="tailette-config"
```

This will publish the config file to `config/tailette.php` where you can modify the default settings:

```php
return [
    // Default color palette (blue)
    'default_palette' => [
        '50' => '#eff6ff',
        '100' => '#dbeafe',
        // ...
    ],
    
    // Cache duration in minutes (1 day by default)
    'cache_duration' => 60 * 24,
];
```

## Usage

### Basic Usage

```php
use DanieleBuso\Tailette\Facades\Tailette;

// Generate a palette from a hex color (with or without #)
$palette = Tailette::generate('#3b82f6');
// or
$palette = Tailette::generate('3b82f6');

// The result is a collection with keys 50, 100, 200, ..., 950
// Each value is a hex color code
echo $palette['500']; // #3b82f6 (the original color)
echo $palette['200']; // A lighter shade
echo $palette['800']; // A darker shade
```

### Without Caching

If you need to bypass the cache (for testing or other purposes):

```php
$palette = Tailette::generatePalette('3b82f6');
```

### Using in Blade Templates

```blade
<div class="bg-[{{ Tailette::generate('3b82f6')['500'] }}]">
    This div has a background color of the base color
</div>

<div class="bg-[{{ Tailette::generate('3b82f6')['200'] }}]">
    This div has a background color of a lighter shade
</div>
```

### Using with Tailwind Config

You can use this package to dynamically generate color palettes for your Tailwind config:

```js
// tailwind.config.js
const colors = require('./colors.json');

module.exports = {
  theme: {
    extend: {
      colors: colors,
    },
  },
  // ...
}
```

Then in your Laravel application, you can generate the colors.json file:

```php
$colors = [
    'primary' => Tailette::generate('#3b82f6')->toArray(),
    'secondary' => Tailette::generate('#10b981')->toArray(),
    // Add more colors as needed
];

file_put_contents(
    public_path('colors.json'), 
    json_encode($colors, JSON_PRETTY_PRINT)
);
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.