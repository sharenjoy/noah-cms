<?php

namespace Sharenjoy\NoahCms\Resources\CarouselResource\Pages;

use Sharenjoy\NoahCms\Resources\CarouselResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;
use Filament\Resources\Pages\EditRecord;

class EditCarousel extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = CarouselResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
