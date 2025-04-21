<?php

namespace Sharenjoy\NoahCms\Resources\CurrencyResource\Pages;

use Sharenjoy\NoahCms\Resources\CurrencyResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;
use Filament\Resources\Pages\EditRecord;

class EditCurrency extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = CurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
