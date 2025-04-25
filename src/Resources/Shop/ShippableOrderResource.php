<?php

namespace Sharenjoy\NoahCms\Resources\Shop;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Resources\Resource;
use Sharenjoy\NoahCms\Models\ShippableOrder;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderInfoListAction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderPickingListAction;
use Sharenjoy\NoahCms\Resources\Shop\Traits\OrderableResource;

class ShippableOrderResource extends Resource implements HasShieldPermissions
{
    use OrderableResource;

    protected static ?string $model = ShippableOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?int $navigationSort = 8;

    public static function getModelLabel(): string
    {
        return __('noah-cms::noah-cms.shippable_order');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->shippable()->count();
    }

    public static function getBulkActions(): array
    {
        return [
            ViewOrderInfoListAction::make(resource: 'shippable-orders', actionType: 'bulk'),
            ViewOrderPickingListAction::make(resource: 'shippable-orders', actionType: 'bulk'),
        ];
    }

    public static function getPages(): array
    {
        return [
            'view' => Pages\Shippable\ViewOrder::route('/{record}'),
            'index' => Pages\Shippable\ListOrders::route('/'),
            'info-list' => Pages\Shippable\ViewOrderInfoList::route('/{record}/info-list'),
            'picking-list' => Pages\Shippable\ViewOrderPickingList::route('/{record}/picking-list'),
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
