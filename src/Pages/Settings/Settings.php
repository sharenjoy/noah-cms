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

class Settings extends BaseSettings
{
    use HasPageShield;

    protected static ?int $navigationSort = 47;

    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';

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
                        ->visible(fn(): bool => ShopFeatured::run('shop'))
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
                    Tabs\Tab::make('shop')
                        ->label('促銷相關')
                        ->visible(fn(): bool => ShopFeatured::run('shop'))
                        ->schema([
                            Section::make('折扣設定')->schema([
                                Radio::make('shop.decimal_point_calculate_type')
                                    ->label(__('noah-cms::noah-cms.shop.promo.title.decimal_point_calculate_type'))
                                    ->options([
                                        'floor' => '無條件捨去',
                                        'ceil' => '無條件進位',
                                        'round' => '四捨五入',
                                    ])
                                    ->inline()
                                    ->inlineLabel(false),
                                Fieldset::make('百分比折抵方式')
                                    ->columns(1)
                                    ->schema([
                                        Radio::make('shop.discount_percent_amount_type')
                                            ->label(__('noah-cms::noah-cms.shop.promo.title.discount_percent_amount_type'))
                                            ->helperText(new HtmlString(__('noah-cms::noah-cms.shop.promo.help.discount_percent_amount_type')))
                                            ->options([
                                                'entire' => '整筆訂單金額計算折抵',
                                                'product' => '只有符合商品合計金額計算折抵',
                                            ])
                                            ->inline()
                                            ->inlineLabel(false)
                                            ->live(),
                                        Radio::make('shop.discount_percent_calculate_type')
                                            ->label(__('noah-cms::noah-cms.shop.promo.title.discount_percent_calculate_type'))
                                            ->helperText(new HtmlString(__('noah-cms::noah-cms.shop.promo.help.discount_percent_calculate_type')))
                                            ->options([
                                                'combined' => '疊加折抵',
                                                'devided' => '分開折抵',
                                            ])
                                            ->inline()
                                            ->inlineLabel(false)
                                            ->visible(fn(Get $get): bool => $get('shop.discount_percent_amount_type') == 'entire'),
                                    ]),
                            ]),
                        ]),
                    Tabs\Tab::make('code')
                        ->label('語法相關')
                        ->visible(fn(): bool => RoleCan::run(role: 'creator'))
                        ->schema([
                            // Section::make('折扣碼條件設定(此區塊保留給維護工程人員使用)')
                            //     ->schema([
                            //         Repeater::make('code.promo_conditions')
                            //             ->label('條件')
                            //             ->schema([
                            //                 TextInput::make('name')
                            //                     ->label('條件名稱')
                            //                     ->required()
                            //                     ->placeholder('輸入條件名稱'),

                            //                 Textarea::make('code')
                            //                     ->label('條件程式碼')
                            //                     ->rows(5)
                            //                     ->required()
                            //                     ->placeholder('輸入條件程式碼')
                            //             ])
                            //             ->addActionLabel('新增條件') // 自訂新增按鈕的文字
                            //             ->collapsible(false) // 允許展開/摺疊每個項目
                            //             ->defaultItems(1) // 預設新增一個條件
                            //             ->deletable(true) // 禁止刪除
                            //             ->reorderable(true)
                            //             ->minItems(1), // 最少需要一個條件

                            //     ]),
                            Section::make('使用者條件設定(此區塊保留給維護工程人員使用)')
                                ->schema([
                                    Repeater::make('code.user_conditions')
                                        ->label('條件')
                                        ->schema([
                                            TextInput::make('name')
                                                ->label('條件名稱')
                                                ->required()
                                                ->placeholder('輸入條件名稱'),

                                            Textarea::make('code')
                                                ->label('條件程式碼')
                                                ->rows(5)
                                                ->required()
                                                ->placeholder('輸入條件程式碼')
                                        ])
                                        ->addActionLabel('新增條件') // 自訂新增按鈕的文字
                                        ->collapsible(false) // 允許展開/摺疊每個項目
                                        ->defaultItems(1) // 預設新增一個條件
                                        ->deletable(true) // 禁止刪除
                                        ->reorderable(true)
                                        ->minItems(1), // 最少需要一個條件

                                ]),
                            Section::make('商品條件設定(此區塊保留給維護工程人員使用)')
                                ->schema([
                                    Repeater::make('code.product_conditions')
                                        ->label('條件')
                                        ->schema([
                                            TextInput::make('name')
                                                ->label('條件名稱')
                                                ->required()
                                                ->placeholder('輸入條件名稱'),

                                            Textarea::make('code')
                                                ->label('條件程式碼')
                                                ->rows(5)
                                                ->required()
                                                ->placeholder('輸入條件程式碼')
                                        ])
                                        ->addActionLabel('新增條件') // 自訂新增按鈕的文字
                                        ->collapsible(false) // 允許展開/摺疊每個項目
                                        ->defaultItems(1) // 預設新增一個條件
                                        ->deletable(true) // 禁止刪除
                                        ->reorderable(true)
                                        ->minItems(1), // 最少需要一個條件

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
