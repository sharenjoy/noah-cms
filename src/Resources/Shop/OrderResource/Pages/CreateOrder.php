<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;

class CreateOrder extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
