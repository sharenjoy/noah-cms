<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages;

use Filament\Resources\Pages\Page;
use Sharenjoy\NoahCms\Models\Order;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;

class ViewOrderInfoList extends Page
{
    use NoahCreateRecord;

    protected static string $resource = OrderResource::class;

    protected static string $view = 'noah-cms::pages.order-info-list';

    public function getTitle(): string
    {
        return __('noah-cms::noah-cms.view_order_info_list');
    }

    public $models;

    public $ids;

    public function mount($record)
    {
        if (request()->has('ids')) {
            $this->ids = request()->get('ids');
        } else {
            $this->ids = [$record];
        }

        $this->models = Order::with(['user', 'items', 'invoice.prices', 'transaction', 'shipment'])->whereIn('id', $this->ids)->get();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
