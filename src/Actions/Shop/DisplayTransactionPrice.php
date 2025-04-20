<?php

namespace Sharenjoy\NoahCms\Actions\Shop;

use Illuminate\Support\Number;
use Lorisleiva\Actions\Concerns\AsAction;
use Sharenjoy\NoahCms\Models\Transaction;

class DisplayTransactionPrice
{
    use AsAction;

    public function handle(Transaction $transaction)
    {
        // TODO 將precision換為資料庫管理欄位值
        if ($transaction->currency == 'TWD') {
            return Number::currency($transaction->total_price, in: $transaction->currency, precision: 0);
        }

        return Number::currency($transaction->total_price, in: $transaction->currency);
    }
}
