<?php

namespace Sharenjoy\NoahCms\Resources\Shop\MinSpendPromoResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Sharenjoy\NoahCms\Resources\Shop\MinSpendPromoResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;

class ListPromos extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = MinSpendPromoResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
