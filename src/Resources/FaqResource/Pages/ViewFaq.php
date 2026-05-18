<?php

namespace Sharenjoy\NoahCms\Resources\FaqResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Sharenjoy\NoahCms\Resources\FaqResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;

class ViewFaq extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = FaqResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
