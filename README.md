# This is my package noah-cms

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

Add laravel-debugbar repository to composer require-dev

```json
"barryvdh/laravel-debugbar": "^3.15",
```

You can install the package via composer:

```bash
composer require sharenjoy/noah-cms:dev-main
```

```
Copy NoahPanelProvider.php to app/Providers folder
```

Add this line to bootstrap/providers.php

```php
App\Providers\NoahPanelProvider::class,
```

Replace this to user model

```php
<?php

namespace App\Models;

use Sharenjoy\NoahCms\Models\User as NoahCmsUser;

class User extends NoahCmsUser {}
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

```bash
php artisan shield:generate --all
```

You can publish assets and run the migrations with:

```bash
php artisan filament:assets
```

You can run the storage link with:

```bash
php artisan storage:link
```

You can publish the assets using

```bash
php artisan vendor:publish --tag="noah-cms-assets"
```

```
Copy all lang/vendor folder to lang/ folder
```

Optionally, You can publish the config file with:

```bash
php artisan vendor:publish --tag="noah-cms-config"
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

aside {
    background-color: rgb(243 243 243) !important;
}
.fi-main-ctn {
    background-color: rgb(248 248 248) !important;
}
aside nav ul.fi-sidebar-group-items li.fi-active a {
    background-color: rgb(250 250 250) !important;
}
aside nav ul.fi-sidebar-group-items li a:hover {
    background-color: rgb(255, 255, 255) !important;
}
ul li.fi-sidebar-group .fi-sidebar-group-label {
    color: #000 !important;
}
.fi-ta-image img {
    border-radius: 0.5rem !important;
}

@media (min-width: 1681px) {
    aside nav ul.fi-sidebar-nav-groups {
        row-gap: 1.3rem !important;
    }
    .fi-sidebar-item a {
        padding: 0.32rem !important;
    }
    .fi-sidebar-item a span.fi-badge {
        padding: 0.15rem !important;
    }
    .fi-sidebar-item-icon,
    .fi-sidebar-item-grouped-border {
        width: 1.25rem !important;
        height: 1.25rem !important;
    }
}

@media (max-width: 1680px) {
    aside {
        width: 12rem !important;
    }
    aside nav {
        padding-top: 1.5rem !important;
        padding-bottom: 1.5rem !important;
        padding-left: 1.3rem !important;
        padding-right: 0.8rem !important;
    }
    aside nav ul.fi-sidebar-nav-groups {
        row-gap: 1.3rem !important;
    }
    main {
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
    }
    .fi-sidebar-item a {
        padding: 0.15rem !important;
        column-gap: 0.4rem !important;
    }
    .fi-sidebar-item a span {
        font-size: 0.8rem !important;
    }
    .fi-sidebar-item a span.fi-badge {
        padding: 0rem !important;
    }
    .fi-sidebar-item-icon,
    .fi-sidebar-item-grouped-border {
        width: 1.1rem !important;
        height: 1.1rem !important;
    }
}
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
        "./vendor/guava/filament-modal-relation-managers/resources/**/*.blade.php",
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
