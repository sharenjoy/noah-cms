<?php

namespace Sharenjoy\NoahCms\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Sharenjoy\NoahCms\Actions\Shop\ShopFeatured;
use Sharenjoy\NoahCms\Models\Order;
use Sharenjoy\NoahCms\Resources\Shop\NewOrderResource;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource;
use Squire\Models\Currency;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    protected static ?string $heading = '最新訂單';

    public static function canView(): bool
    {
        return ShopFeatured::run('shop');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery()->new())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns(\Sharenjoy\NoahCms\Utils\Table::make(Order::class))
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('檢視')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Order $record): string => NewOrderResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
