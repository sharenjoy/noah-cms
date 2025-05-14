<?php

namespace Sharenjoy\NoahCms\Resources\StaticPageResource\Pages;

use Sharenjoy\NoahCms\Resources\StaticPageResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;
use Filament\Resources\Pages\ViewRecord;

class ViewStaticPage extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = StaticPageResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
