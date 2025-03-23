<?php

namespace Sharenjoy\NoahCms;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Sharenjoy\NoahCms\Resources\UserResource;

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
                UserResource::class,
            ])
            ->pages([]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
