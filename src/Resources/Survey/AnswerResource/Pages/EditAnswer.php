<?php

namespace Sharenjoy\NoahCms\Resources\Survey\AnswerResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Sharenjoy\NoahCms\Resources\Survey\AnswerResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;

class EditAnswer extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = AnswerResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
