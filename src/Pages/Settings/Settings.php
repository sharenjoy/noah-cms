<?php

namespace Sharenjoy\NoahCms\Pages\Settings;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Closure;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;

class Settings extends BaseSettings
{
    use HasPageShield;

    protected static ?int $navigationSort = 47;

    protected static ?string $navigationIcon = 'heroicon-m-cog-8-tooth';

    public static function getNavigationGroup(): string
    {
        return __('noah-cms::noah-cms.resource');
    }

    public function schema(): array|Closure
    {
        return [
            Tabs::make('Settings')
                ->contained(false)
                ->persistTabInQueryString()
                ->schema([
                    Tabs\Tab::make('General')
                        ->translateLabel()
                        ->schema([
                            TextInput::make('general.app_name')
                                ->label(__('noah-cms::noah-cms.website_name'))
                                ->required()
                                ->translatable(true, null, [
                                    'en' => ['required', 'string', 'max:255'],
                                    'zh_TW' => ['required', 'string', 'max:255'],
                                ]),
                        ]),
                    Tabs\Tab::make('SEO')
                        ->schema([
                            TextInput::make('seo.title')
                                ->label(__('noah-cms::noah-cms.seo_title'))
                                ->required()
                                ->translatable(true, null, [
                                    'en' => ['required', 'string', 'max:255'],
                                    'zh_TW' => ['required', 'string', 'max:255'],
                                ]),
                            TextInput::make('seo.description')
                                ->label(__('noah-cms::noah-cms.seo_description'))
                                ->required()
                                ->translatable(true, null, [
                                    'en' => ['required', 'string', 'max:255'],
                                    'zh_TW' => ['required', 'string', 'max:255'],
                                ]),
                        ]),
                ]),
        ];
    }
}
