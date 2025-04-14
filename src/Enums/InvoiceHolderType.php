<?php

namespace Sharenjoy\NoahCms\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum InvoiceHolderType: string implements HasLabel, HasDescription, HasIcon, HasColor
{
    case Mobile = 'mobile';
    case Certificate = 'certificate';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Mobile => __('noah-cms::noah-cms.shop.type.invoice_holder.mobile'),
            self::Certificate => __('noah-cms::noah-cms.shop.type.invoice_holder.certificate'),
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Mobile => '描述.',
            self::Certificate => '描述.',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Mobile => 'heroicon-o-newspaper',
            self::Certificate => 'heroicon-c-trophy',
        };
    }

    public function getColor(): array|string|null
    {
        return match ($this) {
            self::Mobile => Color::Blue,
            self::Certificate => Color::Amber,
        };
    }
}
