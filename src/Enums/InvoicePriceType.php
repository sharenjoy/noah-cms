<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum InvoicePriceType: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    case Product = 'product';
    case ProductDiscount = 'product_discount';
    case Delivery = 'delivery';
    case Shoppingmoney = 'shoppingmoney';
    case Point = 'point';
    case Promo = 'promo';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Product => __('noah-cms::noah-cms.shop.type.invoice_price.product'),
            self::ProductDiscount => __('noah-cms::noah-cms.shop.type.invoice_price.product_discount'),
            self::Delivery => __('noah-cms::noah-cms.shop.type.invoice_price.delivery'),
            self::Shoppingmoney => __('noah-cms::noah-cms.shop.type.invoice_price.shoppingmoney'),
            self::Point => __('noah-cms::noah-cms.shop.type.invoice_price.point'),
            self::Promo => __('noah-cms::noah-cms.shop.type.invoice_price.promo'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Product => '描述.',
            self::ProductDiscount => '描述.',
            self::Delivery => '描述.',
            self::Shoppingmoney => '描述.',
            self::Point => '描述.',
            self::Promo => '描述.',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Product => 'heroicon-o-newspaper',
            self::ProductDiscount => 'heroicon-o-newspaper',
            self::Delivery => 'heroicon-c-trophy',
            self::Shoppingmoney => 'heroicon-c-trophy',
            self::Point => 'heroicon-c-trophy',
            self::Promo => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Product => Color::Blue,
            self::ProductDiscount => Color::Blue,
            self::Delivery => Color::Amber,
            self::Shoppingmoney => Color::Amber,
            self::Point => Color::Amber,
            self::Promo => Color::Amber,
        };
    }
}
