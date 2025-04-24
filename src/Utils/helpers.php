<?php

if (!function_exists('format_currency')) {
    function format_currency($amount, $symbol = '$')
    {
        return $symbol . number_format($amount, 2);
    }
}

if (!function_exists('enum_to_array')) {
    function enum_to_array(string $enumClass): array
    {
        return collect($enumClass::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->name])
            ->toArray();
    }
}
