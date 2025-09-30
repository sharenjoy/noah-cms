<?php

// config for Sharenjoy/NoahCms
return [

    'models' => [
        'User' => \App\Models\User::class,
        'Menu' => \Sharenjoy\NoahCms\Models\Menu::class,
        'Post' => \Sharenjoy\NoahCms\Models\Post::class,
        'Role' => \Sharenjoy\NoahCms\Models\Role::class,
        'Tag' => \Sharenjoy\NoahCms\Models\Tag::class,
        'Category' => \Sharenjoy\NoahCms\Models\Category::class,
        'StaticPage' => \Sharenjoy\NoahCms\Models\StaticPage::class,
        'Carousel' => \Sharenjoy\NoahCms\Models\Carousel::class,
    ],

    'enums' => [
        'TagType' => \Sharenjoy\NoahCms\Enums\TagType::class,
    ],

    'plugins' => [
        'resources' => [
            \Sharenjoy\NoahCms\Resources\CategoryResource::class,
            \Sharenjoy\NoahCms\Resources\MenuResource::class,
            \Sharenjoy\NoahCms\Resources\PostResource::class,
            \Sharenjoy\NoahCms\Resources\RoleResource::class,
            \Sharenjoy\NoahCms\Resources\TagResource::class,
            \Sharenjoy\NoahCms\Resources\UserResource::class,
            \Sharenjoy\NoahCms\Resources\StaticPageResource::class,
            \Sharenjoy\NoahCms\Resources\CarouselResource::class,
        ],
        'pages' => [
            \Sharenjoy\NoahCms\Pages\Activities::class,
        ],
        'widgets' => [
            \Sharenjoy\NoahCms\Resources\CategoryResource\Widgets\CategoryWidget::class,
            \Sharenjoy\NoahCms\Resources\MenuResource\Widgets\MenuWidget::class,
        ],
    ],

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

    // 這些 enum 的值會被隱藏在選單中
    'hidden' => [
        'TagType' => [
            'product',
            'promo',
        ],
    ],

    'creator_emails' => [
        'ronald.jian@gmail.com',
    ],

];
