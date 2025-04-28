<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Issued;

use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ViewRecord;
use Sharenjoy\NoahCms\Resources\Shop\IssuedOrderResource;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\UpdateOrderStatusAction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderInfoListAction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderPickingListAction;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;

class ViewOrder extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = IssuedOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                UpdateOrderStatusAction::make(order: $this->record),
                ViewOrderInfoListAction::make(resource: 'issued-orders'),
                ViewOrderPickingListAction::make(resource: 'issued-orders'),
            ])
                ->label('更多操作')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('primary')
                ->button(),
        ];
    }
}
