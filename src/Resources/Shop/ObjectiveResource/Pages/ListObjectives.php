<?php

namespace Sharenjoy\NoahCms\Resources\Shop\ObjectiveResource\Pages;

use Sharenjoy\NoahCms\Resources\Shop\ObjectiveResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;
use Filament\Resources\Pages\ListRecords;

class ListObjectives extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = ObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
