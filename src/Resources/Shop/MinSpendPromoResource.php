<?php

namespace Sharenjoy\NoahCms\Resources\Shop;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Sharenjoy\NoahCms\Enums\PromoType;
use Sharenjoy\NoahCms\Models\MinSpendPromo;
use Sharenjoy\NoahCms\Resources\Shop\MinSpendPromoResource\Pages;
use Sharenjoy\NoahCms\Resources\Shop\Traits\PromoableResource;

class MinSpendPromoResource extends Resource implements HasShieldPermissions
{
    use PromoableResource;

    protected static ?string $model = MinSpendPromo::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?int $navigationSort = 24;

    public static function getModelLabel(): string
    {
        return __('noah-cms::noah-cms.min_spend_promo');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereType(PromoType::MinSpend->value);
    }

    protected static function getPromoFormSchema(): array
    {
        return [
            Section::make('滿額折扣設定')
                ->schema([
                    Hidden::make('type')->default(PromoType::MinSpend->value),
                    TextInput::make('min_spend')
                        ->label(__('noah-cms::noah-cms.shop.promo.title.min_spend'))
                        ->helperText(new HtmlString(__('noah-cms::noah-cms.shop.promo.help.min_spend')))
                        ->prefixIcon('heroicon-o-megaphone')
                        ->suffix('金額')
                        ->placeholder(1000)
                        ->minValue(1)
                        ->numeric()
                        ->required()
                        ->rules(['required', 'numeric', 'min:1']),
                ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPromos::route('/'),
            'create' => Pages\CreatePromo::route('/create'),
            'edit' => Pages\EditPromo::route('/{record}/edit'),
            'view' => Pages\ViewPromo::route('/{record}'),
        ];
    }
}
