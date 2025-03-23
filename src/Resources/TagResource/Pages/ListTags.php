<?php

namespace Sharenjoy\NoahCms\Resources\TagResource\Pages;

use Sharenjoy\NoahCms\Enums\TagType;
use Sharenjoy\NoahCms\Resources\TagResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTags extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = TagResource::class;

    public function getTabs(): array
    {
        $tabs = [];
        foreach (TagType::cases() as $case) {
            $tabs[$case->value] = Tab::make($case->getLabel())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('type', $case->value))
                ->icon($case->getIcon());
        }

        return $tabs;
    }

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
