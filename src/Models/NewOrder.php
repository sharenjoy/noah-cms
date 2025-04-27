<?php

namespace Sharenjoy\NoahCms\Models;

use Sharenjoy\NoahCms\Models\BaseOrder;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions\ViewOrderItemsAction;

class NewOrder extends BaseOrder
{
    protected $table = 'orders';

    public function viewOrderItemsAction()
    {
        return ViewOrderItemsAction::make(fn(NewOrder $order) => view('noah-cms::tables.columns.order-items', ['order' => $order]));
    }
}
