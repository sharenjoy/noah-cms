<?php

namespace Sharenjoy\NoahCms\Resources\PostResource\Pages;

use Sharenjoy\NoahCms\Resources\PostResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
