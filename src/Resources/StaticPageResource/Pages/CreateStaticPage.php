<?php

namespace Sharenjoy\NoahCms\Resources\StaticPageResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Sharenjoy\NoahCms\Resources\StaticPageResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahCreateRecord;

class CreateStaticPage extends CreateRecord
{
    use NoahCreateRecord;

    protected static string $resource = StaticPageResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
