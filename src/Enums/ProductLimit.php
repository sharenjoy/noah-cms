<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ProductLimit: string implements HasLabel, HasIcon, HasColor
{
    case Deliveryhome = 'deliveryhome';
    case Pickinstore = 'pickinstore';
    case International = 'international';
    case Coupon = 'coupon';
    case Point = 'point';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Deliveryhome => __('noah-cms::noah-cms.no_deliveryhome'),
            self::Pickinstore => __('noah-cms::noah-cms.no_pickinstore'),
            self::International => __('noah-cms::noah-cms.no_international'),
            self::Coupon => __('noah-cms::noah-cms.no_coupon'),
            self::Point => __('noah-cms::noah-cms.no_point'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Deliveryhome => 'heroicon-o-newspaper',
            self::Pickinstore => 'heroicon-c-trophy',
            self::International => 'heroicon-c-trophy',
            self::Coupon => 'heroicon-c-trophy',
            self::Point => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Deliveryhome => Color::Blue,
            self::Pickinstore => Color::Amber,
            self::International => Color::Amber,
            self::Coupon => Color::Amber,
            self::Point => Color::Amber,
        };
    }
}
