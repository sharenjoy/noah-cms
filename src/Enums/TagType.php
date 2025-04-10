<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TagType: string implements HasLabel, HasIcon, HasColor
{
    case Post = 'post';
    case Product = 'product';
    case User = 'user';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Post => __('noah-cms::noah-cms.post'),
            self::Product => __('noah-cms::noah-cms.product'),
            self::User => __('noah-cms::noah-cms.user'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Post => 'heroicon-o-newspaper',
            self::Product => 'heroicon-c-trophy',
            self::User => 'heroicon-c-users',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Post => Color::Blue,
            self::Product => Color::Amber,
            self::User => Color::Orange,
        };
    }
}
