<?php

namespace Sharenjoy\NoahCms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Sharenjoy\NoahCms\Models\Transaction;

class ChargeExpireDateSetting
{
    use AsAction;

    public function handle(Transaction $transaction): Transaction
    {
        $transaction->expired_at = now()->addDays(3)->timestamp;
        $transaction->atm_code = '11111234567890';

        return $transaction;
    }
}
