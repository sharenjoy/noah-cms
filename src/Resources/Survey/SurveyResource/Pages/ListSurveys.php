<?php

namespace Sharenjoy\NoahCms\Resources\Survey\SurveyResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Sharenjoy\NoahCms\Resources\Survey\SurveyResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;

class ListSurveys extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = SurveyResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
