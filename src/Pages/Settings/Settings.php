<?php

namespace Sharenjoy\NoahCms\Pages\Settings;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Closure;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;
use RalphJSmit\Filament\MediaLibrary\Forms\Components\MediaPicker;

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
                        ->label(__('noah-cms::noah-cms.general'))
                        ->schema([
                            Section::make()->schema([
                                TextInput::make('general.app_name')
                                    ->label(__('noah-cms::noah-cms.website_name'))
                                    ->required()
                                    ->translatable(true, null, [
                                        'en' => ['string', 'max:255'],
                                        'zh_TW' => ['required', 'string', 'max:255'],
                                    ]),
                                MediaPicker::make('general.logo')->label('Logo(品牌/公司)')->showFileName(),
                                TextInput::make('general.contact_email')
                                    ->label('Email(聯絡信箱)')
                                    ->required(),
                                TextInput::make('general.contact_phone')
                                    ->label('聯絡電話')
                                    ->required(),
                                TextInput::make('general.contact_address')
                                    ->label('聯絡地址')
                                    ->translatable(true, null, [
                                        'en' => ['string', 'max:255'],
                                        'zh_TW' => ['string', 'max:255'],
                                    ]),
                            ])->columns(1),
                        ]),
                    Tabs\Tab::make('order')
                        ->label('訂單相關')
                        ->schema([
                            Section::make('運費相關')->schema([
                                TextInput::make('order.delivery_free_limit')
                                    ->label('免運金額')
                                    ->numeric()
                                    ->required(),
                                KeyValue::make('order.delivery_price')
                                    ->label('運費設定')
                                    ->addable(false)   // 禁止新增
                                    ->deletable(false) // 禁止刪除
                                    ->keyLabel('地區')
                                    ->valueLabel('運費')
                                    ->required()
                                    ->columnSpanFull(),

                            ]),
                            Section::make('注意事項')->schema([
                                Textarea::make('order.order_info_list.notice')
                                    ->label('訂單明細-注意事項')
                                    ->rows(4)
                                    ->translatable(true, null, [
                                        'zh_TW' => ['required'],
                                    ]),
                                Textarea::make('order.picking_list.notice')
                                    ->label('揀貨單-注意事項')
                                    ->rows(4)
                                    ->translatable(true, null, [
                                        'zh_TW' => ['required'],
                                    ]),

                            ]),
                        ]),
                    Tabs\Tab::make('SEO')
                        ->schema([
                            Section::make()->schema([
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
                        ]),
                ]),
        ];
    }
}
