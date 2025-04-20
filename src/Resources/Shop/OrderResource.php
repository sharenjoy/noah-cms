<?php

namespace Sharenjoy\NoahCms\Resources\Shop;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use RalphJSmit\Filament\Activitylog\Infolists\Components\Timeline;
use Sharenjoy\NoahCms\Actions\Shop\DisplayOrderItemPrice;
use Sharenjoy\NoahCms\Actions\Shop\DisplayTransactionPrice;
use Sharenjoy\NoahCms\Enums\InvoiceType;
use Sharenjoy\NoahCms\Enums\OrderStatus;
use Sharenjoy\NoahCms\Enums\TransactionStatus;
use Sharenjoy\NoahCms\Models\Invoice;
use Sharenjoy\NoahCms\Models\InvoicePrice;
use Sharenjoy\NoahCms\Models\Order;
use Sharenjoy\NoahCms\Models\OrderItem;
use Sharenjoy\NoahCms\Models\Transaction;
use Sharenjoy\NoahCms\Models\User;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\RelationManagers\InvoicePricesRelationManager;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\RelationManagers\OrderItemsRelationManager;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\RelationManagers\UserRelationManager;
use Sharenjoy\NoahCms\Resources\Traits\NoahBaseResource;
use Sharenjoy\NoahCms\Resources\UserResource;

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
        return parent::getEloquentQuery()->with(['user.orders', 'user.tags', 'shipment', 'shipments', 'invoice', 'transaction', 'items']);
    }

    public static function form(Form $form): Form
    {
        return $form->columns(3)->schema([]);
    }

    public static function table(Table $table): Table
    {
        $table = static::chainTableFunctions($table);
        return $table
            // ->modifyQueryUsing(fn(Builder $query) => $query->with(['user']))
            ->columns(\Sharenjoy\NoahCms\Utils\Table::make(static::getModel()))
            ->filters([
                SelectFilter::make('status')
                    ->label(__('noah-cms::noah-cms.order_status'))
                    ->options(OrderStatus::class),
                // SelectFilter::make('transaction')
                //     ->label(__('noah-cms::noah-cms.transaction_type'))
                //     ->relationship('transaction', 'status')
                //     ->options(TransactionStatus::class),
                // SelectFilter::make('invoice')
                //     ->label(__('noah-cms::noah-cms.invoice_type'))
                //     ->relationship('invoice', 'type')
                //     ->options(InvoiceType::class),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->reorderable(false);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make(__('noah-cms::noah-cms.order'))
                    ->schema([
                        \Sharenjoy\NoahCms\Infolists\Components\OrderEntry::make(''),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
                // \Filament\Infolists\Components\Section::make(__('noah-cms::noah-cms.order_items'))
                //     ->schema([
                //         \Sharenjoy\NoahCms\Infolists\Components\OrderItemsEntry::make(''),
                //     ])
                //     ->collapsible()
                //     ->columnSpanFull(),
                \Filament\Infolists\Components\Section::make(__('noah-cms::noah-cms.timeline'))
                    ->schema([
                        Timeline::make()
                            ->searchable()
                            ->hiddenLabel()
                            ->attributeLabel('status', __('noah-cms::noah-cms.status'))
                            ->attributeLabel('price', __('noah-cms::noah-cms.price'))
                            ->attributeLabel('discount', __('noah-cms::noah-cms.discount'))
                            ->attributeLabel('total_price', __('noah-cms::noah-cms.total_price'))
                            ->withRelations(['items', 'invoice', 'transaction', 'invoicePrices'])
                            ->getRecordTitleUsing(OrderItem::class, function (OrderItem $model) {
                                return $model->product->title . '(' . implode(',', $model->product_details['spec_detail_name']) . ') x ' . $model->quantity . ' ' . __('noah-cms::noah-cms.item_subtotal') . ' ' . DisplayOrderItemPrice::run($model);
                            })
                            ->getRecordTitleUsing(Invoice::class, function (Invoice $model) {
                                return $model->type->getLabel();
                            })
                            ->getRecordTitleUsing(InvoicePrice::class, function (InvoicePrice $model) {
                                return $model->type->getLabel() . ' ' . $model->value;
                            })
                            ->getRecordTitleUsing(Transaction::class, function (Transaction $model) {
                                return $model->status->getLabel() . ' ' . $model->provider->getLabel() . ' ' . $model->payment_method->getLabel() . ' ' . DisplayTransactionPrice::run($model);
                            })
                            ->eventDescription('published', "The subject name is :subject.title, the causer name is :causer.name and Laravel is :properties.status"),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            OrderItemsRelationManager::class,
            InvoicePricesRelationManager::class,
            UserRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'view' => Pages\ViewOrder::route('/{record}'),
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            // 'edit' => Pages\EditOrder::route('/{record}/edit'),
            // 'invoice' => Pages\Invoice::route('/{record}/invoice'),
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
