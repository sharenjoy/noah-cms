<?php

namespace Sharenjoy\NoahCms\Resources\Survey\SurveyResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Sharenjoy\NoahCms\Resources\Survey\SurveyResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;

class CreateSurvey extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = SurveyResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
