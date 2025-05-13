<?php

namespace Sharenjoy\NoahCms\Resources\Shop\MinQuantityPromoResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Sharenjoy\NoahCms\Resources\Shop\MinQuantityPromoResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;

class ViewPromo extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = MinQuantityPromoResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
