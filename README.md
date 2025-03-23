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
composer require sharenjoy/noah-cms
```

Replace this to user model

```php
namespace App\Models;

use Sharenjoy\NoahCms\Models\User as NoahCmsUser;

class User extends NoahCmsUser {}
```

Add this to boot method in AppServiceProvider

```php
public function boot(): void
{
    \Illuminate\Database\Eloquent\Model::unguard();

    \Filament\Tables\Actions\CreateAction::configureUsing(function ($action) {
        return $action->slideOver();
    });
}
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="noah-cms-migrations"
php artisan migrate
php artisan storage:link
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="noah-cms-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="noah-cms-views"
```

Optionally, you can publish the assets using

```bash
php artisan vendor:publish --tag="noah-cms-assets"
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
