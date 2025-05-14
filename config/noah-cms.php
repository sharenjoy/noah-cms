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

    'feature' => [
        'logActivity' => env('FEATURE_TOGGLE_LOGACTIVITY', false),
        'seo' => env('FEATURE_TOGGLE_SEO', true),
        'coin-point' => env('FEATURE_TOGGLE_POINT', true),
        'coin-shoppingmoney' => env('FEATURE_TOGGLE_SHOPPINGMONEY', false),
    ],

    'promo' => [
        'conditions_decrypter' => env('PROMO_CONDITIONS_DECRYPTER', 'ronaldiscreator'),
        'conditions_divider' => env('PROMO_CONDITIONS_DIVIDER', ':::'),
        'coupon_divider' => env('PROMO_COUPON_DIVIDER', '::'),
    ],

    'donate_code' => [
        //
    ],

    // 這些 enum 的值會被隱藏在選單中
    'hidden' => [
        'OrderStatus' => [
            'initial',
        ],
        'DeliveryProvider' => [
            'tcat',
            'fedex',
        ],
        'StockMethod' => [
            'preorderable',
        ],
        'CoinType' => [
            'shoppingmoney',
        ],
    ],
];
