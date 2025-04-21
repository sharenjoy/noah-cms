<?php

namespace Sharenjoy\NoahCms\Resources\CurrencyResource\Pages;

use Sharenjoy\NoahCms\Resources\CurrencyResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;
use Filament\Resources\Pages\ListRecords;

class ListCurrencies extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = CurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
