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
        'log-activity' => env('NOAHCMS_FEATURE_LOGACTIVITY', false),
        'seo' => env('NOAHCMS_FEATURE_SEO', true),
    ],

    'shop-feature' => [
        'shop' => env('NOAHCMS_FEATURE_SHOP', true),
        'coin-point' => env('NOAHCMS_FEATURE_POINT', true),
        'coin-shoppingmoney' => env('NOAHCMS_FEATURE_SHOPPINGMONEY', true),
    ],

    'promo' => [
        'conditions_decrypter' => env('PROMO_CONDITIONS_DECRYPTER', 'ronaldiscreator'),
        'conditions_divider' => env('PROMO_CONDITIONS_DIVIDER', ':::'),
        'coupon_divider' => env('PROMO_COUPON_DIVIDER', '::'),
    ],

    'donate_code' => [
        // 322833 => '天主教花蓮教區醫療財團法人',
        // 17930 => '社團法人台灣環境資訊協會',
        // 876 => '財團法人心路社會福利基金會',
        // 2880 => '台灣原生植物保育協會',
        // 7495 => '社團法人臺灣野灣野生動物保育協會',
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

    'creator_emails' => [
        'ronald.jian@gmail.com',
    ],

];
