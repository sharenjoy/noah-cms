<?php

namespace Sharenjoy\NoahCms\Resources\UserResource\Pages;

use Sharenjoy\NoahCms\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
