<?php

namespace Sharenjoy\NoahCms\Resources\TagResource\Pages;

use Sharenjoy\NoahCms\Resources\TagResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;
use Filament\Actions\ReplicateAction;
use Filament\Facades\Filament;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTag extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
