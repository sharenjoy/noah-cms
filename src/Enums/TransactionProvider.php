<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TransactionProvider: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    case TapPay = 'tappay';
    case LINEPay = 'linepay';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TapPay => __('noah-cms::noah-cms.shop.provider.title.transaction.tappay'),
            self::LINEPay => __('noah-cms::noah-cms.shop.provider.title.transaction.linepay'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::TapPay => __('noah-cms::noah-cms.shop.provider.description.transaction.tappay'),
            self::LINEPay => __('noah-cms::noah-cms.shop.provider.description.transaction.linepay'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::TapPay => 'heroicon-o-newspaper',
            self::LINEPay => 'heroicon-o-newspaper',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::TapPay => Color::Blue,
            self::LINEPay => Color::Blue,
        };
    }
}
