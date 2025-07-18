<?php

namespace Sharenjoy\NoahCms\Resources\UserResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;
use Sharenjoy\NoahCms\Resources\UserResource;
use Sharenjoy\NoahCms\Resources\UserResource\Actions\UpdateUserPasswordAction;

class ViewUser extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([
            UpdateUserPasswordAction::make(),
        ], $this->recordHeaderActions());
    }
}
