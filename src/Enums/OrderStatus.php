<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    case Initial = 'initial';
    case New = 'new';
    case Processing = 'processing';
    case Pending = 'pending';
    case Cancelled = 'cancelled';
    case Finished = 'finished';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Initial => __('noah-cms::noah-cms.shop.status.order.initial'),
            self::New => __('noah-cms::noah-cms.shop.status.order.new'),
            self::Processing => __('noah-cms::noah-cms.shop.status.order.processing'),
            self::Pending => __('noah-cms::noah-cms.shop.status.order.pending'),
            self::Cancelled => __('noah-cms::noah-cms.shop.status.order.cancelled'),
            self::Finished => __('noah-cms::noah-cms.shop.status.order.finished'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Initial => '描述.',
            self::New => '描述.',
            self::Processing => '描述.',
            self::Pending => '描述.',
            self::Cancelled => '描述.',
            self::Finished => '描述.',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Initial => 'heroicon-o-newspaper',
            self::New => 'heroicon-o-newspaper',
            self::Processing => 'heroicon-c-trophy',
            self::Pending => 'heroicon-c-trophy',
            self::Cancelled => 'heroicon-c-trophy',
            self::Finished => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Initial => Color::Blue,
            self::New => Color::Blue,
            self::Processing => Color::Amber,
            self::Pending => Color::Amber,
            self::Cancelled => Color::Amber,
            self::Finished => Color::Amber,
        };
    }
}
