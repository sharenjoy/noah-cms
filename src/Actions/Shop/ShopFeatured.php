<?php

namespace Sharenjoy\NoahCms\Actions\Shop;

use Lorisleiva\Actions\Concerns\AsAction;

class ShopFeatured
{
    use AsAction;

    public function handle(string $layer): bool
    {
        if (! config('noah-shop.shop-feature.shop')) {
            return false;
        }

        if ($layer && config()->has('noah-shop.shop-feature.' . $layer)) {
            return config('noah-shop.shop-feature.' . $layer);
        }

        return false;
    }
}
