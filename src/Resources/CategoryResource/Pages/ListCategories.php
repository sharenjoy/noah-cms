<?php

namespace Sharenjoy\NoahCms\Resources\CategoryResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Sharenjoy\NoahCms\Resources\CategoryResource;
use Sharenjoy\NoahCms\Resources\CategoryResource\Widgets\CategoryWidget;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;

class ListCategories extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CategoryWidget::class,
        ];
    }
}
