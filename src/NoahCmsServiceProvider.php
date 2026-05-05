<?php

namespace Sharenjoy\NoahCms;

use Illuminate\Database\Eloquent\Relations\Relation;
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
                'twaddress',
            ])
            ->hasViews()
            ->hasTranslations()
            ->discoversMigrations()
            ->hasAssets()
            ->hasCommands([]);
    }

    public function packageBooted()
    {
        $this->enforceMorphMap();

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

    protected function enforceMorphMap(): void
    {
        $models = [
            Models\Carousel::class,
            Models\Category::class,
            Models\Menu::class,
            Models\Permission::class,
            Models\Post::class,
            Models\Role::class,
            Models\Seo::class,
            Models\StaticPage::class,
            Models\Tag::class,
            Models\User::class,
            \Sharenjoy\NoahShop\Models\Product::class,
            \Sharenjoy\NoahShop\Models\Promo::class,
            \Sharenjoy\NoahShop\Models\Survey\Survey::class,
        ];

        $models = array_merge($models, array_values(config('noah-cms.models', [])));

        $morphMap = collect($models)
            ->filter(fn ($model): bool => is_string($model) && class_exists($model))
            ->mapWithKeys(fn (string $model): array => [class_basename($model) => $model])
            ->all();

        $configuredMorphMap = collect(config('noah-cms.morph_map', []))
            ->filter(fn ($model): bool => is_string($model) && class_exists($model))
            ->mapWithKeys(function (string $model, int|string $alias): array {
                $alias = is_string($alias) ? class_basename($alias) : class_basename($model);

                return [$alias => $model];
            })
            ->all();

        $morphMap = array_merge($morphMap, $configuredMorphMap);

        if ($morphMap !== []) {
            Relation::enforceMorphMap($morphMap);
        }
    }
}
