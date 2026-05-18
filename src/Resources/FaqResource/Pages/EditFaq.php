<?php

namespace Sharenjoy\NoahCms\Resources\FaqResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Sharenjoy\NoahCms\Resources\FaqResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;

class EditFaq extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = FaqResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
