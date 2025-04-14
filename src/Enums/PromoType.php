<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PromoType: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    case Coupon = 'coupon';
    case Fullpiece = 'fullpiece';
    case Fullquota = 'fullquota';
    case Deliveryfree = 'deliveryfree';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Coupon => __('noah-cms::noah-cms.shop.type.promo.coupon'),
            self::Fullpiece => __('noah-cms::noah-cms.shop.type.promo.fullpiece'),
            self::Fullquota => __('noah-cms::noah-cms.shop.type.promo.fullquota'),
            self::Deliveryfree => __('noah-cms::noah-cms.shop.type.promo.deliveryfree'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Coupon => '描述.',
            self::Fullpiece => '描述.',
            self::Fullquota => '描述.',
            self::Deliveryfree => '描述.',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Coupon => 'heroicon-o-newspaper',
            self::Fullpiece => 'heroicon-c-trophy',
            self::Fullquota => 'heroicon-c-trophy',
            self::Deliveryfree => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Coupon => Color::Blue,
            self::Fullpiece => Color::Amber,
            self::Fullquota => Color::Amber,
            self::Deliveryfree => Color::Amber,
        };
    }
}
