<?php

namespace Sharenjoy\NoahCms\Models;

use Filament\Tables\Actions\Action;
use Sharenjoy\NoahCms\Models\BaseOrder;

class ShippableOrder extends BaseOrder
{
    protected $table = 'orders';

    public function viewOrderItemsAction()
    {
        return Action::make('view_items')
            ->label(__('noah-cms::noah-cms.order_item_counts'))
            ->modal()
            ->modalCancelAction(false)
            ->modalSubmitAction(false)
            ->modalWidth(\Filament\Support\Enums\MaxWidth::Large)
            ->modalContent(fn(ShippableOrder $order) => view('noah-cms::tables.columns.order-items', ['order' => $order]));
    }
}
