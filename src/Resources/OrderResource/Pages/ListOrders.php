<?php

namespace Sharenjoy\NoahCms\Resources\OrderResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Sharenjoy\NoahCms\Resources\OrderResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;

class ListOrders extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
