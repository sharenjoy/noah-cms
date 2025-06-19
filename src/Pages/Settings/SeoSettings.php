<?php

namespace Sharenjoy\NoahCms\Pages\Settings;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Closure;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;

class SeoSettings extends BaseSettings
{
    use HasPageShield;

    protected static ?int $navigationSort = 72;

    protected static ?string $navigationIcon = null;

    public static function getNavigationGroup(): string
    {
        return __('noah-cms::noah-cms.settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('noah-cms::noah-cms.seo');
    }

    public function schema(): array|Closure
    {
        return [
            Section::make(__('noah-cms::noah-cms.seo'))->schema([
                TextInput::make('seo.title')
                    ->label(__('noah-cms::noah-cms.seo_title'))
                    ->translatable(true, null, [
                        'en' => ['string', 'max:255'],
                        'zh_TW' => ['string', 'max:255'],
                    ]),
                TextInput::make('seo.description')
                    ->label(__('noah-cms::noah-cms.seo_description'))
                    ->translatable(true, null, [
                        'en' => ['string', 'max:255'],
                        'zh_TW' => ['string', 'max:255'],
                    ]),
            ]),
        ];
    }
}
