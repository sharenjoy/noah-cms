<?php

namespace Sharenjoy\NoahCms\Resources\FaqResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Sharenjoy\NoahCms\Resources\FaqResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;

class CreateFaq extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = FaqResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
