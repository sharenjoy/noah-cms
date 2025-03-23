<?php

namespace Sharenjoy\NoahCms;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Sharenjoy\NoahCms\Pages\Activities;
use Sharenjoy\NoahCms\Resources;

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
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
