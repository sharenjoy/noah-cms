<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    case CreditCard = 'creditcard';
    case ATM = 'atm';
    case COD = 'cod';
    case LINEPay = 'linepay';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CreditCard => __('noah-cms::noah-cms.shop.status.transaction.creditcard'),
            self::ATM => __('noah-cms::noah-cms.shop.status.transaction.atm'),
            self::COD => __('noah-cms::noah-cms.shop.status.transaction.cod'),
            self::LINEPay => __('noah-cms::noah-cms.shop.status.transaction.linepay'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::CreditCard => '描述.',
            self::ATM => '描述.',
            self::COD => '描述.',
            self::LINEPay => '描述.',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::CreditCard => 'heroicon-o-newspaper',
            self::ATM => 'heroicon-o-newspaper',
            self::COD => 'heroicon-c-trophy',
            self::LINEPay => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::CreditCard => Color::Blue,
            self::ATM => Color::Blue,
            self::COD => Color::Amber,
            self::LINEPay => Color::Amber,
        };
    }
}
