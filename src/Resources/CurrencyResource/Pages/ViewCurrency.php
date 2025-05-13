<?php

namespace Sharenjoy\NoahCms\Resources\CurrencyResource\Pages;

use Sharenjoy\NoahCms\Resources\CurrencyResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;
use Filament\Resources\Pages\ViewRecord;

class ViewCurrency extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = CurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
