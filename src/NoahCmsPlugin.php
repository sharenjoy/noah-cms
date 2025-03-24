<?php

namespace Sharenjoy\NoahCms;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Sharenjoy\NoahCms\Pages\Activities;
use Sharenjoy\NoahCms\Resources;
use Sharenjoy\NoahCms\Resources\CategoryResource\Widgets\CategoryWidget;
use Sharenjoy\NoahCms\Resources\MenuResource\Widgets\MenuWidget;

class NoahCmsPlugin implements Plugin
{
    protected bool $hasEmailVerifiedAt = false;

    public static function make(): NoahCmsPlugin
    {
        return new NoahCmsPlugin();
    }

    public function getId(): string
    {
        return 'noah-cms';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                Resources\CategoryResource::class,
                Resources\MenuResource::class,
                Resources\PostResource::class,
                Resources\TagResource::class,
                Resources\UserResource::class,
            ])
            ->pages([
                Activities::class,
            ])
            ->widgets([
                CategoryWidget::class,
                MenuWidget::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
