<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Illuminate\Database\Eloquent\Builder;
use Sharenjoy\NoahCms\Tables\Columns\OrderInvoiceColumn;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;

class OrderInvoice extends TableAbstract implements TableInterface
{
    public function make()
    {
        return OrderInvoiceColumn::make('invoice')
            ->searchable(query: function (Builder $query, string $search): Builder {
                return $query->whereHas('invoice', function ($query) use ($search) {
                    $query->where('company_title', 'like', "%{$search}%")
                        ->orWhere('company_code', 'like', "%{$search}%")
                        ->orWhere('holder_code', 'like', "%{$search}%");
                });
            })
            ->label(__('noah-cms::noah-cms.' . ($this->content['label'] ?? $this->fieldName)))
            ->toggleable(isToggledHiddenByDefault: $this->content['isToggledHiddenByDefault'] ?? false);
    }
}
