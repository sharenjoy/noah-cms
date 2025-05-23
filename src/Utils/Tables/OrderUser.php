<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Illuminate\Database\Eloquent\Builder;
use Sharenjoy\NoahCms\Tables\Columns\OrderUserColumn;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;

class OrderUser extends TableAbstract implements TableInterface
{
    public function make()
    {
        return OrderUserColumn::make('user')
            ->searchable(query: function (Builder $query, string $search): Builder {
                return $query->whereHas('user', function ($query) use ($search) {
                    // TODO
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('sn', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%")
                        ->orWhere('birthday', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->label(__('noah-cms::noah-cms.' . ($this->content['label'] ?? $this->fieldName)))
            ->toggleable(isToggledHiddenByDefault: $this->content['isToggledHiddenByDefault'] ?? false);
    }
}
