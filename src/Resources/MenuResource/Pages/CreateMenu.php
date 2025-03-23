<?php

namespace Sharenjoy\NoahCms\Resources\MenuResource\Pages;

use Sharenjoy\NoahCms\Resources\MenuResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;
use Filament\Resources\Pages\CreateRecord;

class CreateMenu extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = MenuResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
