<?php

namespace Sharenjoy\NoahCms\Resources\ProductResource\Pages;

use Sharenjoy\NoahCms\Resources\ProductResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
