<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Illuminate\Database\Eloquent\Builder;
use Sharenjoy\NoahCms\Tables\Columns\OrderShipmentColumn;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;

class OrderShipment extends TableAbstract implements TableInterface
{
    public function make()
    {
        return OrderShipmentColumn::make('shipment')
            ->searchable(query: function (Builder $query, string $search): Builder {
                return $query->whereHas('shipment', function ($query) use ($search) {
                    $query->where('sn', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%")
                        ->orWhere('country', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('district', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('postoffice_delivery_code', 'like', "%{$search}%");
                });
            })
            ->label(__('noah-cms::noah-cms.' . ($this->content['label'] ?? $this->fieldName)))
            ->toggleable(isToggledHiddenByDefault: $this->content['isToggledHiddenByDefault'] ?? false);
    }
}
