<?php

namespace Sharenjoy\NoahCms\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use RalphJSmit\Filament\MediaLibrary\Media\Pages\MediaLibrary as BaseMediaLibrary;

class MediaLibrary extends BaseMediaLibrary
{
    use HasPageShield;

    protected static ?int $navigationSort = 45;

    public static function getNavigationGroup(): string
    {
        return __('noah-cms::noah-cms.resource');
    }
}
