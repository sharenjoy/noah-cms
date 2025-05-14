<?php

namespace Sharenjoy\NoahCms\Actions\Shop;

use Lorisleiva\Actions\Concerns\AsAction;

class ShopFeatured
{
    use AsAction;

    public function handle(string $layer): bool
    {
        if (! config('noah-cms.shop-feature.shop')) {
            return false;
        }

        if ($layer && config()->has('noah-cms.shop-feature.' . $layer)) {
            return config('noah-cms.shop-feature.' . $layer);
        }

        return false;
    }
}
