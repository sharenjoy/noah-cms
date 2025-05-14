<?php

namespace Sharenjoy\NoahCms\Resources\StaticPageResource\Pages;

use Sharenjoy\NoahCms\Resources\StaticPageResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;
use Filament\Resources\Pages\ListRecords;

class ListStaticPages extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = StaticPageResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
