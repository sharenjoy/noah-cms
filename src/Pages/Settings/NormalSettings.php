<?php

namespace Sharenjoy\NoahCms\Pages\Settings;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Closure;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Illuminate\Support\HtmlString;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;
use RalphJSmit\Filament\MediaLibrary\Forms\Components\MediaPicker;
use Sharenjoy\NoahCms\Actions\Shop\RoleCan;
use Sharenjoy\NoahCms\Actions\Shop\ShopFeatured;

class NormalSettings extends BaseSettings
{
    use HasPageShield;

    protected static ?int $navigationSort = 70;

    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';

    public static function getNavigationGroup(): string
    {
        return __('noah-cms::noah-cms.settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('noah-cms::noah-cms.general');
    }

    public function schema(): array|Closure
    {
        return [
            Section::make('一般設定')->schema([
                TextInput::make('general.app_name')
                    ->label(__('noah-cms::noah-cms.website_name'))
                    ->required()
                    ->translatable(true, null, [
                        'en' => ['string', 'max:255'],
                        'zh_TW' => ['required', 'string', 'max:255'],
                    ]),
                Fieldset::make('資訊')
                    ->columns(1)
                    ->schema([
                        MediaPicker::make('general.logo')->label('Logo(品牌/公司)')->showFileName(),
                        TextInput::make('general.contact_email')
                            ->label('Email(聯絡信箱)')
                            ->required(),
                        TextInput::make('general.contact_phone')
                            ->label('聯絡電話')
                            ->required(),
                    ]),
                TextInput::make('general.contact_address')
                    ->label('聯絡地址')
                    ->translatable(true, null, [
                        'en' => ['string', 'max:255'],
                        'zh_TW' => ['string', 'max:255'],
                    ]),
            ]),

        ];
    }
}
