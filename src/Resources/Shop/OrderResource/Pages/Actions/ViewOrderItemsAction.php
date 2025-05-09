<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions;

use Filament\Facades\Filament;
use Filament\Tables\Actions\Action;

class ViewOrderItemsAction
{
    public static function make($callback)
    {
        return Action::make('view_items')
            ->label(__('noah-cms::noah-cms.order_item_counts'))
            ->modal()
            ->modalCancelAction(false)
            ->modalSubmitAction(false)
            ->modalWidth(\Filament\Support\Enums\MaxWidth::Large)
            ->modalContent($callback);
    }
}
