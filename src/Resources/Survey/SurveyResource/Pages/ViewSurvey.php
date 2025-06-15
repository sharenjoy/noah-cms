<?php

namespace Sharenjoy\NoahCms\Resources\Survey\SurveyResource\Pages;

use Sharenjoy\NoahCms\Resources\Survey\SurveyResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;
use Filament\Resources\Pages\ViewRecord;

class ViewSurvey extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = SurveyResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
