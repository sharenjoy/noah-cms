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

];
