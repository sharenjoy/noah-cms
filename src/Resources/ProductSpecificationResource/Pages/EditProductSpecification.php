<?php

namespace Sharenjoy\NoahCms\Resources\ProductSpecificationResource\Pages;

use Sharenjoy\NoahCms\Resources\ProductSpecificationResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;
use Filament\Resources\Pages\EditRecord;

class EditProductSpecification extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = ProductSpecificationResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
