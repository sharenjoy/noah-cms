<?php

namespace Sharenjoy\NoahCms\Resources\CategoryResource\Pages;

use Sharenjoy\NoahCms\Resources\CategoryResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
