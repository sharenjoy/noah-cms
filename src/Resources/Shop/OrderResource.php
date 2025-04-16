<?php

namespace Sharenjoy\NoahCms\Resources\Shop;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Sharenjoy\NoahCms\Models\Order;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages;
use Sharenjoy\NoahCms\Resources\Traits\NoahBaseResource;

class OrderResource extends Resource implements HasShieldPermissions
{
    use NoahBaseResource;

    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('noah-cms::noah-cms.order');
    }

    public static function getModelLabel(): string
    {
        return __('noah-cms::noah-cms.order');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user.orders', 'user.tags', 'shipment', 'shipments', 'invoice', 'transaction', 'items.specification.product']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema(\Sharenjoy\NoahCms\Utils\Form::make(static::getModel(), $form->getOperation()));
    }

    public static function table(Table $table): Table
    {
        $table = static::chainTableFunctions($table);
        return $table
            // ->modifyQueryUsing(fn(Builder $query) => $query->with(['user']))
            ->columns(\Sharenjoy\NoahCms\Utils\Table::make(static::getModel()))
            ->filters(\Sharenjoy\NoahCms\Utils\Filter::make(static::getModel()))
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ActionGroup::make(array_merge(static::getTableActions(), [])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(array_merge(static::getBulkActions(), [])),
            ])
            ->reorderable(false);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
        ];
    }
}
