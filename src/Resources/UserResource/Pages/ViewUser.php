<?php

namespace Sharenjoy\NoahCms\Resources\UserResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;
use Sharenjoy\NoahCms\Resources\UserResource;

class ViewUser extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
