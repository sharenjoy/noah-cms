<?php

namespace Sharenjoy\NoahCms;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Sharenjoy\NoahCms\Commands\NoahCmsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NoahCmsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('noah-cms')
            ->hasConfigFile()
            ->hasConfigFile([
                'activitylog',
                'filament-shield',
                'filament-tiptap-editor',
                'filament-tree',
                'media-library',
                'noah-cms',
                'seo',
                'tags',
            ])
            ->hasViews()
            ->hasTranslations()
            ->discoversMigrations()
            ->hasAssets()
            ->hasCommand(NoahCmsCommand::class);
    }

    public function packageBooted()
    {
        FilamentAsset::register([
            Css::make('noah-cms-theme', __DIR__ . '/../resources/dist/js/theme.css'),
        ], 'sharenjoy/noah-cms');
    }
}
