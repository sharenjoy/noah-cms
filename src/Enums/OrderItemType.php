<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderItemType: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    case Product = 'product';
    case Group = 'group';
    case Freegift = 'freegift';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Product => __('noah-cms::noah-cms.shop.type.order_item.product'),
            self::Group => __('noah-cms::noah-cms.shop.type.order_item.group'),
            self::Freegift => __('noah-cms::noah-cms.shop.type.order_item.freegift'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Product => '描述.',
            self::Group => '描述.',
            self::Freegift => '描述.',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Product => 'heroicon-o-newspaper',
            self::Group => 'heroicon-c-trophy',
            self::Freegift => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Product => Color::Blue,
            self::Group => Color::Amber,
            self::Freegift => Color::Amber,
        };
    }
}
