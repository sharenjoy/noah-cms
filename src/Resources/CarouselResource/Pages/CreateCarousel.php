<?php

namespace Sharenjoy\NoahCms\Resources\CarouselResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Sharenjoy\NoahCms\Resources\CarouselResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;

class CreateCarousel extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = CarouselResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
