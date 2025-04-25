<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Shippable;

use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ViewRecord;
use Sharenjoy\NoahCms\Resources\Shop\ShippableOrderResource;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderInfoListAction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderPickingListAction;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;

class ViewOrder extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = ShippableOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                ViewOrderInfoListAction::make(resource: 'shippable-orders'),
                ViewOrderPickingListAction::make(resource: 'shippable-orders'),
            ])
                ->label('更多操作')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('primary')
                ->button(),
        ];
    }
}
