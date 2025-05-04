<?php

namespace Sharenjoy\NoahCms\Resources\Shop\ObjectiveResource\Pages;

use Sharenjoy\NoahCms\Resources\Shop\ObjectiveResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;
use Filament\Resources\Pages\EditRecord;

class EditObjective extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = ObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
