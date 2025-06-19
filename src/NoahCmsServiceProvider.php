<?php

namespace Sharenjoy\NoahCms;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NoahCmsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('noah-cms')
            ->hasRoute('web')
            ->hasConfigFile([
                'activitylog',
                'filament-activity-log',
                'filament-shield',
                'filament-tiptap-editor',
                'filament-tree',
                'laravellocalization',
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
            ->hasCommands([]);
    }

    public function packageBooted()
    {
        \Illuminate\Database\Eloquent\Model::unguard();

        \Filament\Tables\Actions\CreateAction::configureUsing(function ($action) {
            return $action->slideOver();
        });
        \Filament\Tables\Actions\EditAction::configureUsing(function ($action) {
            return $action->slideOver();
        });
        \Filament\Forms\Components\Actions\Action::configureUsing(function ($action) {
            return $action->slideOver();
        });

        \Filament\Tables\Table::configureUsing(function (\Filament\Tables\Table $table): void {
            $table
                ->paginated([25, 50, 100, 200])
                ->defaultPaginationPageOption(25);
        });
    }
}
