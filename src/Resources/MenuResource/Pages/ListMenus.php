<?php

namespace Sharenjoy\NoahCms\Resources\MenuResource\Pages;

use Sharenjoy\NoahCms\Resources\MenuResource;
use Sharenjoy\NoahCms\Resources\MenuResource\Widgets\MenuWidget;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;
use Filament\Resources\Pages\ListRecords;

class ListMenus extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = MenuResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MenuWidget::class
        ];
    }
}
