<?php

namespace Sharenjoy\NoahCms\Resources\Shop\MinQuantityPromoResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Sharenjoy\NoahCms\Resources\Shop\MinQuantityPromoResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;

class CreatePromo extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = MinQuantityPromoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
