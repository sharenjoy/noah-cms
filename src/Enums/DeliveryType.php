<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum DeliveryType: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    case Address = 'address';
    case Pickinstore = 'pickinstore';
    case Pickinretail = 'pickinretail';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Address => __('noah-cms::noah-cms.shop.type.title.delivery.address'),
            self::Pickinstore => __('noah-cms::noah-cms.shop.type.title.delivery.pickinstore'),
            self::Pickinretail => __('noah-cms::noah-cms.shop.type.title.delivery.pickinretail'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Address => __('noah-cms::noah-cms.shop.type.description.delivery.address'),
            self::Pickinstore => __('noah-cms::noah-cms.shop.type.description.delivery.pickinstore'),
            self::Pickinretail => __('noah-cms::noah-cms.shop.type.description.delivery.pickinretail'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Address => 'heroicon-o-newspaper',
            self::Pickinstore => 'heroicon-o-newspaper',
            self::Pickinretail => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Address => Color::Blue,
            self::Pickinstore => Color::Blue,
            self::Pickinretail => Color::Amber,
        };
    }
}
