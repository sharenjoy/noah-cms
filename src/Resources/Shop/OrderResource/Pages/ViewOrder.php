<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages;

use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ViewRecord;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\EditInvoiceAction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\EditShipmentAction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\EditTransactionAction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\UpdateOrderStatusAction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderInfoListAction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderPickingListAction;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;

class ViewOrder extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {

        return [
            ActionGroup::make([
                UpdateOrderStatusAction::make(order: $this->record),
                EditShipmentAction::make(order: $this->record),
                EditInvoiceAction::make(order: $this->record),
                EditTransactionAction::make(order: $this->record),
                ViewOrderInfoListAction::make('orders'),
                ViewOrderPickingListAction::make('orders'),
            ])
                ->label('更多操作')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('primary')
                ->button(),
        ];
    }
}
