<?php

namespace Sharenjoy\NoahCms;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Sharenjoy\NoahCms\Pages\Activities;
use Sharenjoy\NoahCms\Resources;
use Sharenjoy\NoahCms\Resources\CategoryResource\Widgets\CategoryWidget;
use Sharenjoy\NoahCms\Resources\MenuResource\Widgets\MenuWidget;

class NoahCmsPlugin implements Plugin
{
    protected bool $hasEmailVerifiedAt = false;

    public static function make(): NoahCmsPlugin
    {
        return new NoahCmsPlugin();
    }

    public function getId(): string
    {
        return 'noah-cms';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                Resources\CategoryResource::class,
                Resources\MenuResource::class,
                Resources\PostResource::class,
                Resources\ProductResource::class,
                Resources\ProductSpecificationResource::class,
                Resources\CurrencyResource::class,
                Resources\BrandResource::class,
                Resources\RoleResource::class,
                Resources\TagResource::class,
                Resources\UserResource::class,
                Resources\Shop\OrderResource::class,
                Resources\Shop\NewOrderResource::class,
                Resources\Shop\ShippableOrderResource::class,
                Resources\Shop\ShippedOrderResource::class,
                Resources\Shop\DeliveredOrderResource::class,
                Resources\Shop\IssuedOrderResource::class,
                Resources\Shop\CouponPromoResource::class,
                Resources\Shop\MinSpendPromoResource::class,
                Resources\Shop\MinQuantityPromoResource::class,
                Resources\Shop\ObjectiveResource::class,
                Resources\Shop\UserLevelResource::class,
                Resources\GiftproductResource::class,
            ])
            ->pages([
                Activities::class,
            ])
            ->widgets([
                CategoryWidget::class,
                MenuWidget::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
