<?php

namespace Sharenjoy\NoahCms\Resources\ProductSpecificationResource\Pages;

use Sharenjoy\NoahCms\Resources\ProductSpecificationResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;
use Filament\Resources\Pages\ListRecords;

class ListProductSpecifications extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = ProductSpecificationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
