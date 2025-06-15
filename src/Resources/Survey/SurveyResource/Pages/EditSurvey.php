<?php

namespace Sharenjoy\NoahCms\Resources\Survey\SurveyResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Sharenjoy\NoahCms\Resources\Survey\SurveyResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;

class EditSurvey extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = SurveyResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
