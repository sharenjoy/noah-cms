<?php

namespace Sharenjoy\NoahCms\Resources\Shop;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Resources\Resource;
use Sharenjoy\NoahCms\Models\NewOrder;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderInfoListAction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderPickingListAction;
use Sharenjoy\NoahCms\Resources\Shop\Traits\OrderableResource;

class NewOrderResource extends Resource implements HasShieldPermissions
{
    use OrderableResource;

    protected static ?string $model = NewOrder::class;

    // protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return __('noah-cms::noah-cms.new_order');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->new()->count();
    }

    public static function getBulkActions(): array
    {
        return [
            ViewOrderInfoListAction::make(resource: 'new-orders', actionType: 'bulk'),
            ViewOrderPickingListAction::make(resource: 'new-orders', actionType: 'bulk'),
        ];
    }

    public static function getPages(): array
    {
        return [
            'view' => Pages\New\ViewOrder::route('/{record}'),
            'index' => Pages\New\ListOrders::route('/'),
            'info-list' => Pages\New\ViewOrderInfoList::route('/{record}/info-list'),
            'picking-list' => Pages\New\ViewOrderPickingList::route('/{record}/picking-list'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
        ];
    }
}
