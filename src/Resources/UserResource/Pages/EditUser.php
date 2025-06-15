<?php

namespace Sharenjoy\NoahCms\Resources\UserResource\Pages;

use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;
use Sharenjoy\NoahCms\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
