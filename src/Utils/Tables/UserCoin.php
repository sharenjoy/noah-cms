<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Illuminate\Database\Eloquent\Builder;
use Sharenjoy\NoahCms\Tables\Columns\UserCoinColumn;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;

class UserCoin extends TableAbstract implements TableInterface
{
    public function make()
    {
        return UserCoinColumn::make('point')
            ->label(__('noah-cms::noah-cms.' . ($this->content['label'] ?? $this->fieldName)))
            ->toggleable(isToggledHiddenByDefault: $this->content['isToggledHiddenByDefault'] ?? false);
    }
}
