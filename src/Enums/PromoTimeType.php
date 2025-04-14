<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PromoTimeType: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    case Forever = 'forever';
    case Timeline = 'timeline';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Forever => __('noah-cms::noah-cms.shop.type.promo_time.forever'),
            self::Timeline => __('noah-cms::noah-cms.shop.type.promo_time.timeline'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Forever => '描述.',
            self::Timeline => '描述.',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Forever => 'heroicon-o-newspaper',
            self::Timeline => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Forever => Color::Blue,
            self::Timeline => Color::Amber,
        };
    }
}
