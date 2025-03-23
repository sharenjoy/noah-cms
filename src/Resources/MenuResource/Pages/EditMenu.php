<?php

namespace Sharenjoy\NoahCms\Resources\MenuResource\Pages;

use Sharenjoy\NoahCms\Resources\MenuResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;
use Filament\Resources\Pages\EditRecord;

class EditMenu extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = MenuResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
