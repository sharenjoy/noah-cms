<?php

namespace Sharenjoy\NoahCms\Resources\PostResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Sharenjoy\NoahCms\Resources\PostResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;

class CreatePost extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
