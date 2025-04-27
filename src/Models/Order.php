<?php

namespace Sharenjoy\NoahCms\Models;

use Sharenjoy\NoahCms\Models\BaseOrder;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderItemsAction;

class Order extends BaseOrder
{
    protected $table = 'orders';

    public function viewOrderItemsAction()
    {
        return ViewOrderItemsAction::make(fn(Order $order) => view('noah-cms::tables.columns.order-items', ['order' => $order]));
    }
}
