<?php

namespace Sharenjoy\NoahCms\Resources\StaticPageResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Sharenjoy\NoahCms\Resources\StaticPageResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;

class ViewStaticPage extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = StaticPageResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
