<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahCms\Enums\Traits\BaseEnum;

enum ObjectiveType: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

    case User = 'user';
    case Product = 'product';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::User => __('noah-cms::noah-cms.shop.type.title.objective.user'),
            self::Product => __('noah-cms::noah-cms.shop.type.title.objective.product'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::User => __('noah-cms::noah-cms.shop.type.description.objective.user'),
            self::Product => __('noah-cms::noah-cms.shop.type.description.objective.product'),
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::User => Color::Purple,
            self::Product => Color::Teal,
        };
    }
}
