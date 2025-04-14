<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderShipmentStatus: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    case New = 'new';
    case Shipped = 'shipped';
    case Delivered = 'delivered';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::New => __('noah-cms::noah-cms.shop.status.shipment.new'),
            self::Shipped => __('noah-cms::noah-cms.shop.status.shipment.shipped'),
            self::Delivered => __('noah-cms::noah-cms.shop.status.shipment.delivered'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::New => '描述.',
            self::Shipped => '描述.',
            self::Delivered => '描述.',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::New => 'heroicon-o-newspaper',
            self::Shipped => 'heroicon-o-newspaper',
            self::Delivered => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Shipped => Color::Blue,
            self::Shipped => Color::Blue,
            self::Delivered => Color::Amber,
        };
    }
}
