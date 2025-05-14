<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Sharenjoy\NoahCms\Actions\Shop\ShopFeatured;
use Sharenjoy\NoahCms\Tables\Columns\UserCoinColumn;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;

class UserCoin extends TableAbstract implements TableInterface
{
    public function make()
    {
        return UserCoinColumn::make('point')
            ->visible(fn() => ShopFeatured::run('coin-point') || ShopFeatured::run('coin-shoppingmoney'))
            ->label(__('noah-cms::noah-cms.' . ($this->content['label'] ?? $this->fieldName)))
            ->toggleable(isToggledHiddenByDefault: $this->content['isToggledHiddenByDefault'] ?? false);
    }
}
