<?php

namespace Sharenjoy\NoahCms\Resources\Shop;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Resources\Resource;
use Sharenjoy\NoahCms\Models\DeliveredOrder;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderInfoListAction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderPickingListAction;
use Sharenjoy\NoahCms\Resources\Shop\Traits\OrderableResource;

class DeliveredOrderResource extends Resource implements HasShieldPermissions
{
    use OrderableResource;

    protected static ?string $model = DeliveredOrder::class;

    protected static ?int $navigationSort = 15;

    public static function getModelLabel(): string
    {
        return __('noah-cms::noah-cms.delivered_order');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->delivered()->count();
    }

    public static function getBulkActions(): array
    {
        return [
            ViewOrderInfoListAction::make(resource: 'delivered-orders', actionType: 'bulk'),
            ViewOrderPickingListAction::make(resource: 'delivered-orders', actionType: 'bulk'),
        ];
    }

    public static function getPages(): array
    {
        return [
            'view' => Pages\Delivered\ViewOrder::route('/{record}'),
            'index' => Pages\Delivered\ListOrders::route('/'),
            'info-list' => Pages\Delivered\ViewOrderInfoList::route('/{record}/info-list'),
            'picking-list' => Pages\Delivered\ViewOrderPickingList::route('/{record}/picking-list'),
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
