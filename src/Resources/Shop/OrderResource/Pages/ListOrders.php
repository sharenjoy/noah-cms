<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Builder;
use Sharenjoy\NoahCms\Enums\OrderStatus;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahListRecords;

class ListOrders extends ListRecords
{
    use NoahListRecords;

    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return array_merge([], $this->recordHeaderActions());
    }

    public function getTabs(): array
    {
        $tabs = [];

        $tabs['all'] = Tab::make('ALL')
            ->badge(5)
            ->label(__('noah-cms::noah-cms.shop.status.title.order.all'))
            ->badgeColor(Color::Amber)
            ->modifyQueryUsing(fn(Builder $query) => $query)
            ->icon('');

        foreach (OrderStatus::cases() as $case) {
            $tabs[$case->value] = Tab::make($case->getLabel())
                ->badge(5)
                ->badgeColor(Color::Amber)
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', $case->value))
                ->icon($case->getIcon());
        }

        return $tabs;
    }
}
