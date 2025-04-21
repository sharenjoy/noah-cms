<?php

namespace Sharenjoy\NoahCms\Resources\CurrencyResource\Pages;

use Sharenjoy\NoahCms\Resources\CurrencyResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;
use Filament\Resources\Pages\CreateRecord;

class CreateCurrency extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = CurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
