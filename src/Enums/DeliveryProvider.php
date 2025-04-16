<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum DeliveryProvider: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    case Kerrytj = 'kerrytj';
    case Postoffice = 'postoffice';
    case Tcat = 'tcat';
    case Fedex = 'fedex';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Kerrytj => __('noah-cms::noah-cms.shop.provider.title.delivery.kerrytj'),
            self::Postoffice => __('noah-cms::noah-cms.shop.provider.title.delivery.postoffice'),
            self::Tcat => __('noah-cms::noah-cms.shop.provider.title.delivery.tcat'),
            self::Fedex => __('noah-cms::noah-cms.shop.provider.title.delivery.fedex'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Kerrytj => __('noah-cms::noah-cms.shop.provider.description.delivery.kerrytj'),
            self::Postoffice => __('noah-cms::noah-cms.shop.provider.description.delivery.postoffice'),
            self::Tcat => __('noah-cms::noah-cms.shop.provider.description.delivery.tcat'),
            self::Fedex => __('noah-cms::noah-cms.shop.provider.description.delivery.fedex'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Kerrytj => 'heroicon-o-newspaper',
            self::Postoffice => 'heroicon-o-newspaper',
            self::Tcat => 'heroicon-c-trophy',
            self::Fedex => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Kerrytj => Color::Blue,
            self::Postoffice => Color::Blue,
            self::Tcat => Color::Amber,
            self::Fedex => Color::Amber,
        };
    }
}
