<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages;

use Sharenjoy\NoahCms\Resources\Shop\OrderResource;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\BaseViewOrderLists;

class ViewOrderInfoList extends BaseViewOrderLists
{
    protected static string $resource = OrderResource::class;

    protected static string $view = 'noah-cms::pages.order-info-list';

    public function getTitle(): string
    {
        return __('noah-cms::noah-cms.view_order_info_list');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
