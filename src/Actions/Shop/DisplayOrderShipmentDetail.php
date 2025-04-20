<?php

namespace Sharenjoy\NoahCms\Actions\Shop;

use Lorisleiva\Actions\Concerns\AsAction;
use Sharenjoy\NoahCms\Enums\DeliveryType;
use Sharenjoy\NoahCms\Models\OrderShipment;

class DisplayOrderShipmentDetail
{
    use AsAction;

    public function handle(OrderShipment $shipment)
    {
        $detail = null;

        if ($shipment->delivery_type == DeliveryType::Address) {
            if ($shipment->country == 'Taiwan') {
                $detail = $shipment->city . $shipment->district . ' ' . $shipment->postcode . '<br>' . $shipment->address;
            } else {
                $detail = $shipment->address . '<br>' . $shipment->postcode . ' ' . $shipment->country;
            }
        } elseif ($shipment->delivery_type == DeliveryType::Pickinstore) {
            $detail = $shipment->pickup_store_no . '<br>' . $shipment->pickup_store_name . '<br>' . $shipment->pickup_store_address;
        } elseif ($shipment->delivery_type == DeliveryType::Pickinretail) {
            $detail = $shipment->pickup_retail_name;
        }

        return $detail;
    }
}
