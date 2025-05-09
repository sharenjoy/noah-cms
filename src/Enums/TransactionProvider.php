<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Sharenjoy\NoahCms\Enums\Traits\BaseEnum;

enum TransactionProvider: string implements HasLabel, HasDescription, HasColor
{
    use BaseEnum;

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

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::TapPay => Color::Blue,
            self::LINEPay => Color::Blue,
        };
    }
}
