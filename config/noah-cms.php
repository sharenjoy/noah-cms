<?php

// config for Sharenjoy/NoahCms
return [
    'locale' => [
        'zh_TW' => '中文（台灣）',
        'en' => 'English',
    ],

    'categoryTree' => [
        'maxDepth' => 3,
    ],

    'menuTree' => [
        'maxDepth' => 3,
    ],

    'featureToggle' => [
        'logActivity' => env('FEATURE_TOGGLE_LOGACTIVITY', false),
        'seo' => env('FEATURE_TOGGLE_SEO', true),
    ],

    'promo' => [
        'conditions_decrypter' => env('PROMO_CONDITIONS_DECRYPTER', 'ronaldiscreator'),
        'conditions_divider' => env('PROMO_CONDITIONS_DIVIDER', ':::'),
        'coupon_divider' => env('PROMO_COUPON_DIVIDER', '::'),
    ],

    'donate_code' => [],

];
