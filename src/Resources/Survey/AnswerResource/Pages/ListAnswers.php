<?php

namespace Sharenjoy\NoahCms\Resources\Survey\AnswerResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Sharenjoy\NoahCms\Resources\Survey\AnswerResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;

class ListAnswers extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = AnswerResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
