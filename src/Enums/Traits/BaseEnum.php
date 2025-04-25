<?php

namespace Sharenjoy\NoahCms\Enums\Traits;

trait BaseEnum
{
    public static function toArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
            ->toArray();
    }

    public static function getLabelOptions($value): string|null
    {
        $labels = static::toArray();

        return $labels[$value] ?? null;
    }
}
