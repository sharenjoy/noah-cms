<?php

namespace Sharenjoy\NoahCms\Resources\GiftproductResource\Pages;

use Sharenjoy\NoahCms\Resources\GiftproductResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;
use Filament\Resources\Pages\CreateRecord;

class CreateGiftproduct extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = GiftproductResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
