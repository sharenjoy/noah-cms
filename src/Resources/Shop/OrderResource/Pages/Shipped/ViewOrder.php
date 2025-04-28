<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Shipped;

use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ViewRecord;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\UpdateOrderStatusAction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderInfoListAction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderPickingListAction;
use Sharenjoy\NoahCms\Resources\Shop\ShippedOrderResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;

class ViewOrder extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = ShippedOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                UpdateOrderStatusAction::make(order: $this->record),
                ViewOrderInfoListAction::make(resource: 'shipped-orders'),
                ViewOrderPickingListAction::make(resource: 'shipped-orders'),
            ])
                ->label('更多操作')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('primary')
                ->button(),
        ];
    }
}
