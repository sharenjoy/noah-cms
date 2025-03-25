<?php

namespace Sharenjoy\NoahCms;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Sharenjoy\NoahCms\Commands\NoahCmsCommand;

class NoahCmsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('noah-cms')
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

    public function bootingPackage() {}

    public function packageBooted()
    {
        \Illuminate\Database\Eloquent\Model::unguard();

        \Filament\Tables\Actions\CreateAction::configureUsing(function ($action) {
            return $action->slideOver();
        });
    }
}
