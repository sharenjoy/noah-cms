<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Delivered;

use Sharenjoy\NoahCms\Resources\Shop\DeliveredOrderResource;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\BaseViewOrderLists;

class ViewOrderPickingList extends BaseViewOrderLists
{
    protected static string $resource = DeliveredOrderResource::class;

    protected static string $view = 'noah-cms::pages.picking-list';

    public function getTitle(): string
    {
        return __('noah-cms::noah-cms.view_order_picking_list');
    }
}
