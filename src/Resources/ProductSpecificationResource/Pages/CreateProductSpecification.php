<?php

namespace Sharenjoy\NoahCms\Resources\ProductSpecificationResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Sharenjoy\NoahCms\Resources\ProductSpecificationResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;

class CreateProductSpecification extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = ProductSpecificationResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
