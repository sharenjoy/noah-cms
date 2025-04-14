<?php

namespace Sharenjoy\NoahCms\Actions\Shop;

use Lorisleiva\Actions\Concerns\AsAction;
use Sharenjoy\NoahCms\Models\Invoice;

class CalculatePricesAndUpdateInvoice
{
    use AsAction;

    public function handle(Invoice $invoice)
    {
        $invoicePrices = $invoice->prices()->get();

        $data = [
            'price' => 0,
            'discount' => 0,
            'total_price' => 0,
        ];

        foreach ($invoicePrices as $invoicePrice) {
            if ($invoicePrice->value >= 0) {
                $data['price'] += $invoicePrice->value;
            }

            if ($invoicePrice->value < 0) {
                $data['discount'] += $invoicePrice->value;
            }
        }

        $data['total_price'] = $data['price'] + $data['discount'];

        $invoice->update($data);
    }
}
