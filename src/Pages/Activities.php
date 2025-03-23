<?php

namespace Sharenjoy\NoahCms\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Noxo\FilamentActivityLog\Pages\ListActivities;

class Activities extends ListActivities
{
    use HasPageShield;

    protected bool $isCollapsible = true;

    protected bool $isCollapsed = false;

    protected static ?int $navigationSort = 43;

    public static function getNavigationGroup(): string
    {
        return __('Resource');
    }

    public static function registerNavigationItems(): void
    {
        if (! config('noah.featureToggle.logActivity')) {
            return;
        }

        parent::registerNavigationItems();
    }

    public function getTitle(): string
    {
        return __('filament-activity-log::activities.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-activity-log::activities.title');
    }
}
