<?php

namespace Sharenjoy\NoahCms\Resources\TagResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Sharenjoy\NoahCms\Resources\TagResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;

class ViewTag extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
