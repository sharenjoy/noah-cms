<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahCms\Enums\Traits\BaseEnum;

enum TagType: string implements HasLabel, HasColor
{
    use BaseEnum;

    case Post = 'post';
    case Product = 'product';
    case User = 'user';
    case Promo = 'promo';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Post => __('noah-cms::noah-cms.post'),
            self::Product => __('noah-cms::noah-cms.product'),
            self::User => __('noah-cms::noah-cms.user'),
            self::Promo => __('noah-cms::noah-cms.promo'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Post => Color::Blue,
            self::Product => Color::Amber,
            self::User => Color::Orange,
            self::Promo => Color::Orange,
        };
    }
}
