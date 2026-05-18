<?php

namespace Sharenjoy\NoahCms\Resources\FaqResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Sharenjoy\NoahCms\Resources\FaqResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;

class ListFaqs extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = FaqResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
