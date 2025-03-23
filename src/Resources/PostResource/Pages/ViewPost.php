<?php

namespace Sharenjoy\NoahCms\Resources\PostResource\Pages;

use Sharenjoy\NoahCms\Resources\PostResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;
use Filament\Resources\Pages\ViewRecord;

class ViewPost extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
