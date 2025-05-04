<?php

namespace Sharenjoy\NoahCms\Resources\Shop\MinSpendPromoResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Sharenjoy\NoahCms\Resources\Shop\MinSpendPromoResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;

class EditPromo extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = MinSpendPromoResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
