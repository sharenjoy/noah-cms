<?php

namespace Sharenjoy\NoahCms;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Sharenjoy\NoahCms\Commands\NoahCmsCommand;

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
                'filament-activity-log',
                'filament-shield',
                'filament-tiptap-editor',
                'filament-tree',
                'media-library',
                'noah-cms',
                'permission',
                'seo',
                'tags',
            ])
            ->hasViews()
            ->hasTranslations()
            ->discoversMigrations()
            ->hasAssets()
            ->hasCommand(NoahCmsCommand::class);
    }
}
