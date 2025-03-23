<?php

namespace Sharenjoy\NoahCms\Resources\PostResource\Pages;

use Sharenjoy\NoahCms\Resources\PostResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
