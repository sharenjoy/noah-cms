<?php

namespace Sharenjoy\NoahCms\Resources\TagResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Sharenjoy\NoahCms\Models\Tag;
use Sharenjoy\NoahCms\Resources\TagResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;

class ListTags extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = TagResource::class;

    public function getTabs(): array
    {
        $tabs = [];
        foreach (config('noah-cms.enums.TagType', \Sharenjoy\NoahCms\Enums\TagType::class)::visibleCases() as $case) {
            $tabs[$case->value] = Tab::make($case->getLabel())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('type', $case->value))
                ->badge(fn() => Tag::where('type', $case->value)->count());
        }

        return $tabs;
    }

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }
}
