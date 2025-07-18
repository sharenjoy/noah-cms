<?php

namespace Sharenjoy\NoahCms\Resources\UserResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;
use Sharenjoy\NoahCms\Resources\UserResource;
use Sharenjoy\NoahCms\Resources\UserResource\Actions\UpdateUserPasswordAction;

class EditUser extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([
            UpdateUserPasswordAction::make(),
        ], $this->recordHeaderActions());
    }
}
