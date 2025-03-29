# This is my package noah-cms

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sharenjoy/noah-cms.svg?style=flat-square)](https://packagist.org/packages/sharenjoy/noah-cms)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/sharenjoy/noah-cms/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/sharenjoy/noah-cms/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/sharenjoy/noah-cms/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/sharenjoy/noah-cms/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sharenjoy/noah-cms.svg?style=flat-square)](https://packagist.org/packages/sharenjoy/noah-cms)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/noah-cms.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/noah-cms)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

Add repositories section to composer

```json
"repositories": [
    {
        "type": "composer",
        "url": "https://satis.ralphjsmit.com"
    }
]
```

You can install the package via composer:

```bash
composer require sharenjoy/noah-cms:dev-main
```

Replace this to user model

```php
<?php

namespace App\Models;

use Sharenjoy\NoahCms\Models\User as NoahCmsUser;

class User extends NoahCmsUser {}
```

Update auth.php in config folder

```php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => env('AUTH_MODEL', \Sharenjoy\NoahCms\Models\User::class),
    ],
],
```

You can publish migrations and run migrate and other database related:

```bash
php artisan vendor:publish --tag="noah-cms-migrations"
```

```bash
php artisan migrate
```

```bash
php artisan shield:super-admin
```

You can publish assets and run the migrations with:

```bash
php artisan filament:assets
```

You can run the storage link with:

```bash
php artisan storage:link
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="noah-cms-config"
```

You can publish the assets using

```bash
php artisan vendor:publish --tag="noah-cms-assets"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="noah-cms-views"
```

Optionally, you can publish the translations using

```bash
php artisan vendor:publish --tag="noah-cms-translations" --force
```

Create custom panel theme

```bash
php artisan make:filament-theme
```

Update resources/css/filament/noah/theme.css

```css
@import "/vendor/filament/filament/resources/css/theme.css";
@import "/vendor/awcodes/filament-tiptap-editor/resources/css/plugin.css";

@config 'tailwind.config.js';
```

Update resources/css/filament/noah/tailwind.config.js

```js
import preset from "../../../../vendor/filament/filament/tailwind.config.preset";

export default {
    presets: [preset],
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        "./vendor/ralphjsmit/laravel-filament-media-library/resources/**/*.blade.php",
        "./vendor/awcodes/filament-tiptap-editor/resources/**/*.blade.php",
        "./vendor/solution-forest/filament-tree/resources/**/*.blade.php",
        "./vendor/ralphjsmit/laravel-filament-activitylog/resources/**/*.blade.php",
    ],
};
```

Update vite.config.js

```js
import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/filament/noah/theme.css",
            ],
            refresh: [
                ...refreshPaths,
                "app/Livewire/**",
                "app/Models/**",
                "app/Filament/**",
                "app/Providers/Filament/**",
            ],
            detectTls: "noah-cms.test",
        }),
    ],
});
```

Npm install and build

```bash
npm install
npm run build
```

## Usage

```php
$noahCms = new Sharenjoy\NoahCms();
echo $noahCms->echoPhrase('Hello, Sharenjoy!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Ronald](https://github.com/sharenjoy)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
