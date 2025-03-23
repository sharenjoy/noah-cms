<?php

namespace Sharenjoy\NoahCms\Resources\TagResource\Pages;

use Sharenjoy\NoahCms\Resources\TagResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;
use Filament\Resources\Pages\ViewRecord;

class ViewTag extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
