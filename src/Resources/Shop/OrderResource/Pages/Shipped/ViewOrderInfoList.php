<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Shipped;

use Sharenjoy\NoahCms\Resources\Shop\ShippedOrderResource;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\BaseViewOrderLists;

class ViewOrderInfoList extends BaseViewOrderLists
{
    protected static string $resource = ShippedOrderResource::class;

    protected static string $view = 'noah-cms::pages.order-info-list';

    public function getTitle(): string
    {
        return __('noah-cms::noah-cms.view_order_info_list');
    }
}
