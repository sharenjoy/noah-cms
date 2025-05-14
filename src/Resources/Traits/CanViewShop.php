<?php

namespace Sharenjoy\NoahCms\Resources\Traits;

use Illuminate\Database\Eloquent\Model;
use Sharenjoy\NoahCms\Actions\Shop\ShopFeatured;

trait CanViewShop
{
    public static function canAccess(): bool
    {
        return ShopFeatured::run('shop');
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        if (! ShopFeatured::run('shop')) {
            return false;
        }

        return parent::canViewForRecord($ownerRecord, $pageClass);
    }
}
