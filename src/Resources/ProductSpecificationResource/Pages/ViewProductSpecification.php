<?php

namespace Sharenjoy\NoahCms\Resources\ProductSpecificationResource\Pages;

use Sharenjoy\NoahCms\Resources\ProductSpecificationResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;
use Filament\Resources\Pages\ViewRecord;

class ViewProductSpecification extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = ProductSpecificationResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
