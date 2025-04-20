<?php

namespace Sharenjoy\NoahCms;

use RalphJSmit\Filament\Activitylog\Infolists\Components\Timeline;
use Sharenjoy\NoahCms\Models;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasCommands([
                // NoahCmsCommand::class
            ]);
    }

    public function bootingPackage() {}

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

        Timeline::configureUsing(function (Timeline $timeline) {
            return $timeline
                ->compact()
                ->modelLabels([
                    Models\Invoice::class => __('noah-cms::noah-cms.activity.title.invoice'),
                    Models\Order::class => __('noah-cms::noah-cms.activity.title.order'),
                    Models\InvoicePrice::class => __('noah-cms::noah-cms.activity.title.invoice_price'),
                    Models\OrderItem::class => __('noah-cms::noah-cms.activity.title.order_item'),
                    Models\OrderShipment::class => __('noah-cms::noah-cms.activity.title.order_shipment'),
                    Models\User::class => __('noah-cms::noah-cms.activity.title.user'),
                    Models\Transaction::class => __('noah-cms::noah-cms.activity.title.transaction'),
                    Models\Promo::class => __('noah-cms::noah-cms.activity.title.promo'),
                ])
                ->itemIconColors([
                    'created' => 'info',
                    'deleted' => 'danger',
                ])
                ->itemIcons([
                    'created' => 'heroicon-o-plus',
                    'deleted' => 'heroicon-o-trash',
                ]);
        });
    }
}
