<?php

namespace Sharenjoy\NoahCms\Resources\CarouselResource\Pages;

use Sharenjoy\NoahCms\Resources\CarouselResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;
use Filament\Resources\Pages\ViewRecord;

class ViewCarousel extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = CarouselResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
