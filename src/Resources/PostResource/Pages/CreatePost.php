<?php

namespace Sharenjoy\NoahCms\Resources\PostResource\Pages;

use Sharenjoy\NoahCms\Resources\PostResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
