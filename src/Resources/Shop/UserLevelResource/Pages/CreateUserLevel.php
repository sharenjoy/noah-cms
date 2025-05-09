<?php

namespace Sharenjoy\NoahCms\Resources\Shop\UserLevelResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Sharenjoy\NoahCms\Resources\Shop\UserLevelResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;

class CreateUserLevel extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = UserLevelResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
