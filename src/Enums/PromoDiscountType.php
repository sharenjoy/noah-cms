<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahCms\Enums\Traits\BaseEnum;

enum PromoDiscountType: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    use BaseEnum;

    case Amount = 'amount';
    case Percent = 'percent';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Amount => __('noah-cms::noah-cms.shop.type.title.promo_discount.amount'),
            self::Percent => __('noah-cms::noah-cms.shop.type.title.promo_discount.percent'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Amount => __('noah-cms::noah-cms.shop.type.description.promo_discount.amount'),
            self::Percent => __('noah-cms::noah-cms.shop.type.description.promo_discount.percent'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Amount => 'heroicon-o-newspaper',
            self::Percent => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Amount => Color::Blue,
            self::Percent => Color::Amber,
        };
    }
}
