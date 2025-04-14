<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum InvoiceType: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    case Persion = 'persion';
    case Donate = 'donate';
    case Holder = 'holder';
    case Company = 'company';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Persion => __('noah-cms::noah-cms.shop.type.invoice.persion'),
            self::Donate => __('noah-cms::noah-cms.shop.type.invoice.donate'),
            self::Holder => __('noah-cms::noah-cms.shop.type.invoice.holder'),
            self::Company => __('noah-cms::noah-cms.shop.type.invoice.company'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Persion => '描述.',
            self::Donate => '描述.',
            self::Holder => '描述.',
            self::Company => '描述.',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Persion => 'heroicon-o-newspaper',
            self::Donate => 'heroicon-c-trophy',
            self::Holder => 'heroicon-c-trophy',
            self::Company => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Persion => Color::Blue,
            self::Donate => Color::Amber,
            self::Holder => Color::Amber,
            self::Company => Color::Amber,
        };
    }
}
