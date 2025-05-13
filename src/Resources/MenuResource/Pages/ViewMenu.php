<?php

namespace Sharenjoy\NoahCms\Resources\MenuResource\Pages;

use Sharenjoy\NoahCms\Resources\MenuResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;
use Filament\Resources\Pages\ViewRecord;

class ViewMenu extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = MenuResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
