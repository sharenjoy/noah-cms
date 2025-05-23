<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahCms\Enums\Traits\BaseEnum;

enum DeliveryProvider: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case Kerrytj = 'kerrytj';
    case Postoffice = 'postoffice';
    case Tcat = 'tcat';
    case Fedex = 'fedex';
    case DHL = 'dhl';
    case None = 'none';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Kerrytj => __('noah-cms::noah-cms.shop.provider.title.delivery.kerrytj'),
            self::Postoffice => __('noah-cms::noah-cms.shop.provider.title.delivery.postoffice'),
            self::Tcat => __('noah-cms::noah-cms.shop.provider.title.delivery.tcat'),
            self::Fedex => __('noah-cms::noah-cms.shop.provider.title.delivery.fedex'),
            self::DHL => __('noah-cms::noah-cms.shop.provider.title.delivery.dhl'),
            self::None => __('noah-cms::noah-cms.shop.provider.title.delivery.none'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Kerrytj => __('noah-cms::noah-cms.shop.provider.description.delivery.kerrytj'),
            self::Postoffice => __('noah-cms::noah-cms.shop.provider.description.delivery.postoffice'),
            self::Tcat => __('noah-cms::noah-cms.shop.provider.description.delivery.tcat'),
            self::Fedex => __('noah-cms::noah-cms.shop.provider.description.delivery.fedex'),
            self::DHL => __('noah-cms::noah-cms.shop.provider.description.delivery.dhl'),
            self::None => __('noah-cms::noah-cms.shop.provider.description.delivery.none'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Kerrytj => Color::Gray,
            self::Postoffice => Color::Gray,
            self::Tcat => Color::Gray,
            self::Fedex => Color::Gray,
            self::DHL => Color::Gray,
            self::None => Color::Gray,
        };
    }
}
