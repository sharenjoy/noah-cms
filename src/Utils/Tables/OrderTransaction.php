<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Sharenjoy\NoahCms\Models\Order;
use Sharenjoy\NoahCms\Tables\Columns\OrderShipmentColumn;
use Sharenjoy\NoahCms\Tables\Columns\OrderTransactionColumn;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;

class OrderTransaction extends TableAbstract implements TableInterface
{
    public function make()
    {
        return OrderTransactionColumn::make('transaction')
            ->searchable(query: function (Builder $query, string $search): Builder {
                return $query->whereHas('transaction', function ($query) use ($search) {
                    $query->where('sn', 'like', "%{$search}%")
                        ->orWhere('payment_method', 'like', "%{$search}%")
                        ->orWhere('atm_code', 'like', "%{$search}%");
                });
            })
            ->label(__('noah-cms::noah-cms.' . ($this->content['label'] ?? $this->fieldName)))
            ->toggleable(isToggledHiddenByDefault: $this->content['isToggledHiddenByDefault'] ?? false);
    }
}
