<?php

namespace Sharenjoy\NoahCms\Resources\TagResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Sharenjoy\NoahCms\Resources\TagResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;

class CreateTag extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
