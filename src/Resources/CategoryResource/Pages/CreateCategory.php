<?php

namespace Sharenjoy\NoahCms\Resources\CategoryResource\Pages;

use Sharenjoy\NoahCms\Resources\CategoryResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
