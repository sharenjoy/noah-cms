<?php

namespace Sharenjoy\NoahCms\Resources\MenuResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Sharenjoy\NoahCms\Resources\MenuResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;

class CreateMenu extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = MenuResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
