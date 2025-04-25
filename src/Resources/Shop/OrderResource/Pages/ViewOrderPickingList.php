<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages;

use Sharenjoy\NoahCms\Resources\Shop\OrderResource;

class ViewOrderPickingList extends BaseViewOrderLists
{
    protected static string $resource = OrderResource::class;

    protected static string $view = 'noah-cms::pages.picking-list';

    public function getTitle(): string
    {
        return __('noah-cms::noah-cms.view_order_picking_list');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
