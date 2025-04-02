<?php

namespace Sharenjoy\NoahCms\Resources\ProductResource\Pages;

use Sharenjoy\NoahCms\Resources\ProductResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;
use Filament\Resources\Pages\ViewRecord;

class ViewProduct extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
