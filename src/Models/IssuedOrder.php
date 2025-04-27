<?php

namespace Sharenjoy\NoahCms\Models;

use Sharenjoy\NoahCms\Models\BaseOrder;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderItemsAction;

class IssuedOrder extends BaseOrder
{
    protected $table = 'orders';

    public function viewOrderItemsAction()
    {
        return ViewOrderItemsAction::make(fn(IssuedOrder $order) => view('noah-cms::tables.columns.order-items', ['order' => $order]));
    }
}
