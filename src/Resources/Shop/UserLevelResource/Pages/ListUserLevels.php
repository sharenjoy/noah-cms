<?php

namespace Sharenjoy\NoahCms\Resources\Shop\UserLevelResource\Pages;

use Sharenjoy\NoahCms\Resources\Shop\UserLevelResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;
use Filament\Resources\Pages\ListRecords;

class ListUserLevels extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = UserLevelResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
