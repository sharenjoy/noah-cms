<?php

namespace Sharenjoy\NoahCms\Resources\Shop\ObjectiveResource\Pages;

use Sharenjoy\NoahCms\Resources\Shop\ObjectiveResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;
use Filament\Resources\Pages\ViewRecord;

class ViewObjective extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = ObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
