<?php

namespace Sharenjoy\NoahCms\Resources\CategoryResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Sharenjoy\NoahCms\Resources\CategoryResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;

class CreateCategory extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
