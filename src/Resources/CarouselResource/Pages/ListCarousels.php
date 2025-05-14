<?php

namespace Sharenjoy\NoahCms\Resources\CarouselResource\Pages;

use Sharenjoy\NoahCms\Resources\CarouselResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;
use Filament\Resources\Pages\ListRecords;

class ListCarousels extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = CarouselResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
