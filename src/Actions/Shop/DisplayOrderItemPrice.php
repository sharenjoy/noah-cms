<?php

namespace Sharenjoy\NoahCms\Actions\Shop;

use Illuminate\Support\Number;
use Lorisleiva\Actions\Concerns\AsAction;
use Sharenjoy\NoahCms\Models\OrderItem;

class DisplayOrderItemPrice
{
    use AsAction;

    public function handle(OrderItem $orderItem)
    {
        $amount = ($orderItem->price + $orderItem->discount) * $orderItem->quantity;

        // TODO 將precision換為資料庫管理欄位值
        if ($orderItem->currency == 'TWD') {
            return Number::currency($amount, in: $orderItem->currency, precision: 0);
        }

        return Number::currency($amount, in: $orderItem->currency);
    }
}
