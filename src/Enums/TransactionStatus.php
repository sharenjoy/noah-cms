<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahCms\Enums\Traits\BaseEnum;

enum TransactionStatus: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    use BaseEnum;

    case New = 'new';
    case Pending = 'pending';
    case Expired = 'expired';
    case Paid = 'paid';
    case Refunding = 'refunding';
    case Refunded = 'refunded';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::New => __('noah-cms::noah-cms.shop.status.title.transaction.new'),
            self::Pending => __('noah-cms::noah-cms.shop.status.title.transaction.pending'),
            self::Expired => __('noah-cms::noah-cms.shop.status.title.transaction.expired'),
            self::Paid => __('noah-cms::noah-cms.shop.status.title.transaction.paid'),
            self::Refunding => __('noah-cms::noah-cms.shop.status.title.transaction.refunding'),
            self::Refunded => __('noah-cms::noah-cms.shop.status.title.transaction.refunded'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::New => __('noah-cms::noah-cms.shop.status.description.transaction.new'),
            self::Pending => __('noah-cms::noah-cms.shop.status.description.transaction.pending'),
            self::Expired => __('noah-cms::noah-cms.shop.status.description.transaction.expired'),
            self::Paid => __('noah-cms::noah-cms.shop.status.description.transaction.paid'),
            self::Refunding => __('noah-cms::noah-cms.shop.status.description.transaction.refunding'),
            self::Refunded => __('noah-cms::noah-cms.shop.status.description.transaction.refunded'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::New => 'heroicon-o-newspaper',
            self::Pending => 'heroicon-o-newspaper',
            self::Expired => 'heroicon-c-trophy',
            self::Paid => 'heroicon-c-trophy',
            self::Refunding => 'heroicon-c-trophy',
            self::Refunded => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::New => Color::Blue,
            self::Pending => Color::Blue,
            self::Expired => Color::Amber,
            self::Paid => Color::Amber,
            self::Refunding => Color::Amber,
            self::Refunded => Color::Amber,
        };
    }
}
