<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahCms\Enums\Traits\BaseEnum;

enum OrderStatus: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    use BaseEnum;

    case Initial = 'initial';
    case New = 'new';
    case Processing = 'processing';
    case Pending = 'pending';
    case Cancelled = 'cancelled';
    case Finished = 'finished';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Initial => __('noah-cms::noah-cms.shop.status.title.order.initial'),
            self::New => __('noah-cms::noah-cms.shop.status.title.order.new'),
            self::Processing => __('noah-cms::noah-cms.shop.status.title.order.processing'),
            self::Pending => __('noah-cms::noah-cms.shop.status.title.order.pending'),
            self::Cancelled => __('noah-cms::noah-cms.shop.status.title.order.cancelled'),
            self::Finished => __('noah-cms::noah-cms.shop.status.title.order.finished'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Initial => __('noah-cms::noah-cms.shop.status.description.order.initial'),
            self::New => __('noah-cms::noah-cms.shop.status.description.order.new'),
            self::Processing => __('noah-cms::noah-cms.shop.status.description.order.processing'),
            self::Pending => __('noah-cms::noah-cms.shop.status.description.order.pending'),
            self::Cancelled => __('noah-cms::noah-cms.shop.status.description.order.cancelled'),
            self::Finished => __('noah-cms::noah-cms.shop.status.description.order.finished'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Initial => 'heroicon-o-exclamation-triangle',
            self::New => 'heroicon-o-shopping-cart',
            self::Processing => 'heroicon-c-play-circle',
            self::Pending => 'heroicon-c-play-pause',
            self::Cancelled => 'heroicon-c-x-circle',
            self::Finished => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Initial => Color::Yellow,
            self::New => Color::Sky,
            self::Processing => Color::Emerald,
            self::Pending => Color::Orange,
            self::Cancelled => Color::Gray,
            self::Finished => Color::Indigo,
        };
    }

    public static function getShowableCases(): array
    {
        return [
            // self::Initial,
            self::New,
            self::Processing,
            self::Pending,
            self::Cancelled,
            self::Finished,
        ];
    }

    public static function getShowableOptions(): array
    {
        return collect(self::getShowableCases())
            ->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
            ->toArray();
    }
}
