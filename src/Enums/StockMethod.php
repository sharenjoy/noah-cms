<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StockMethod: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    case Notification = 'notification';
    case Preorderable = 'preorderable';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Notification => __('noah-cms::noah-cms.email_notification'),
            self::Preorderable => __('noah-cms::noah-cms.preorderable'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Notification => '描述.',
            self::Preorderable => '描述.',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Notification => 'heroicon-o-newspaper',
            self::Preorderable => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Notification => Color::Blue,
            self::Preorderable => Color::Amber,
        };
    }
}
