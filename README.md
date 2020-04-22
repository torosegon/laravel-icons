# Easily using your SVG icons in Laravel Blade views

[![Latest Version on Packagist](https://img.shields.io/packagist/v/torosegon/laravel-icons.svg?style=flat-square)](https://packagist.org/packages/torosegon/laravel-icons)

This package is replacing "icon fonts", no more extra bytes, no more extra load time, no more unnecessary HTTP requests.

## Installation

You can install the package via composer:

```bash
composer require torosegon/laravel-icons
```

## Usage
### 1. Component
- Copying icons to the source path eg.: `resources/icons`
- Run generate command. This command converting and minimizing Laravel blade components to the `resources/views/components/icons`

``` bash
php artisan icons:generate
```

- Use Laravel components with `icons` prefix

```html
<icons:chevron class="w-6 h-6" />
```

- Listing and searching in the generated icons:

```bash
php artisan icons:list --name=chevron
```

### 2. HTTP (css, javascript, etc)
All icons available on the `icon` named route. Fully customizable in the config file. 
Basic eg.: `https://example.com/icons/chevron.svg` or with route helper 

```blade
{{ route('icon', 'chevron') }}
```

***

### Configuring
Publishing configuration file

```bash
php artisan vendor:publish --tag=icons:config
```


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information about what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security-related issues, please using the issue tracker.

## Credits

- [Egon Richárd Tőrös](https://github.com/torosegon)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
