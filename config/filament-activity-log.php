<?php

use Noxo\FilamentActivityLog\ResourceLogger\Types\BooleanEnum;

return [
    'loggers' => [
        'directory' => base_path('vendor/sharenjoy/noah-cms/src/Loggers'),
        'namespace' => 'Sharenjoy\\NoahCms\\Loggers',
    ],

    'boolean' => BooleanEnum::class,
];
