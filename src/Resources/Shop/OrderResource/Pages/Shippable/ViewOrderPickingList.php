<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Shippable;

use Sharenjoy\NoahCms\Resources\Shop\ShippableOrderResource;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\BaseViewOrderLists;

class ViewOrderPickingList extends BaseViewOrderLists
{
    protected static string $resource = ShippableOrderResource::class;

    protected static string $view = 'noah-cms::pages.picking-list';

    public function getTitle(): string
    {
        return __('noah-cms::noah-cms.view_order_picking_list');
    }
}
