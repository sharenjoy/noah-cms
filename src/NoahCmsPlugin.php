<?php

namespace Sharenjoy\NoahCms;

use Filament\Contracts\Plugin;
use Filament\Panel;

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
            ->resources(config('noah-cms.plugins.resources'))
            ->pages(config('noah-cms.plugins.pages'))
            ->widgets(config('noah-cms.plugins.widgets'));
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
