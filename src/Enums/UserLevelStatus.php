<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahCms\Enums\Traits\BaseEnum;

enum UserLevelStatus: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case On = 'on';
    case Off = 'off';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::On => __('noah-cms::noah-cms.shop.status.title.user_level_status.on'),
            self::Off => __('noah-cms::noah-cms.shop.status.title.user_level_status.off'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::On => __('noah-cms::noah-cms.shop.status.description.user_level_status.on'),
            self::Off => __('noah-cms::noah-cms.shop.status.description.user_level_status.off'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::On => Color::Green,
            self::Off => Color::Red,
        };
    }
}
