<?php

namespace Sharenjoy\NoahCms\Resources\StaticPageResource\Pages;

use Sharenjoy\NoahCms\Resources\StaticPageResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahEditRecord;
use Filament\Resources\Pages\EditRecord;

class EditStaticPage extends EditRecord
{
    use NoahEditRecord;

    protected static string $resource = StaticPageResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
