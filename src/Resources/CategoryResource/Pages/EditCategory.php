<?php

namespace Sharenjoy\NoahCms\Resources\CategoryResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Sharenjoy\NoahCms\Resources\CategoryResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;

class EditCategory extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
