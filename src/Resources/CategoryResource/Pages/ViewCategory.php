<?php

namespace Sharenjoy\NoahCms\Resources\CategoryResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Sharenjoy\NoahCms\Resources\CategoryResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;

class ViewCategory extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
