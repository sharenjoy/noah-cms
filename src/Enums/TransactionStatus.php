<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TransactionStatus: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    case New = 'new';
    case Pending = 'pending';
    case Expired = 'expired';
    case Finished = 'finished';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::New => __('noah-cms::noah-cms.shop.status.transaction.new'),
            self::Pending => __('noah-cms::noah-cms.shop.status.transaction.pending'),
            self::Expired => __('noah-cms::noah-cms.shop.status.transaction.expired'),
            self::Finished => __('noah-cms::noah-cms.shop.status.transaction.finished'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::New => '描述.',
            self::Pending => '描述.',
            self::Expired => '描述.',
            self::Finished => '描述.',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::New => 'heroicon-o-newspaper',
            self::Pending => 'heroicon-o-newspaper',
            self::Expired => 'heroicon-c-trophy',
            self::Finished => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::New => Color::Blue,
            self::Pending => Color::Blue,
            self::Expired => Color::Amber,
            self::Finished => Color::Amber,
        };
    }
}
