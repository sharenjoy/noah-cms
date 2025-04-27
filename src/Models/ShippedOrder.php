<?php

namespace Sharenjoy\NoahCms\Models;

use Sharenjoy\NoahCms\Models\BaseOrder;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderItemsAction;

class ShippedOrder extends BaseOrder
{
    protected $table = 'orders';

    public function viewOrderItemsAction()
    {
        return ViewOrderItemsAction::make(fn(ShippedOrder $order) => view('noah-cms::tables.columns.order-items', ['order' => $order]));
    }
}
