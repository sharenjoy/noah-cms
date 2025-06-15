<?php

namespace Sharenjoy\NoahCms\Resources\Survey\EntryResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Sharenjoy\NoahCms\Resources\Survey\EntryResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;

class ListEntries extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = EntryResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
