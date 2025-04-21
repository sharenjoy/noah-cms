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
use Sharenjoy\NoahCms\Actions\Shop\DisplayOrderShipmentDetail;
use Sharenjoy\NoahCms\Actions\Shop\DisplayTransactionPrice;
use Sharenjoy\NoahCms\Enums\InvoiceType;
use Sharenjoy\NoahCms\Enums\OrderStatus;
use Sharenjoy\NoahCms\Enums\TransactionStatus;
use Sharenjoy\NoahCms\Models\Invoice;
use Sharenjoy\NoahCms\Models\InvoicePrice;
use Sharenjoy\NoahCms\Models\Order;
use Sharenjoy\NoahCms\Models\OrderItem;
use Sharenjoy\NoahCms\Models\OrderShipment;
use Sharenjoy\NoahCms\Models\Transaction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\RelationManagers\InvoicePricesRelationManager;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\RelationManagers\OrderItemsRelationManager;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\RelationManagers\UserRelationManager;
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
                            ->withRelations(['items', 'invoice', 'transaction', 'invoicePrices', 'shipment'])
                            ->getRecordTitleUsing(OrderItem::class, function (OrderItem $model) {
                                return $model->product->title . '(' . implode(',', $model->product_details['spec_detail_name']) . ') x ' . $model->quantity . ' ' . __('noah-cms::noah-cms.activity.label.item_subtotal') . ' ' . DisplayOrderItemPrice::run($model);
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
                            ->getRecordTitleUsing(OrderShipment::class, function (OrderShipment $model) {
                                return $model->provider->getLabel() . ' ' . $model->delivery_type->getLabel() . ' ' . str_replace('<br>', ' ', DisplayOrderShipmentDetail::run($model));
                            })
                            ->attributeLabel('delivery_type', __('noah-cms::noah-cms.activity.label.delivery_type'))
                            ->attributeLabel('name', __('noah-cms::noah-cms.activity.label.name'))
                            ->attributeLabel('calling_code', __('noah-cms::noah-cms.activity.label.calling_code'))
                            ->attributeLabel('mobile', __('noah-cms::noah-cms.activity.label.mobile'))
                            ->attributeLabel('country', __('noah-cms::noah-cms.activity.label.country'))
                            ->attributeLabel('postcode', __('noah-cms::noah-cms.activity.label.postcode'))
                            ->attributeLabel('city', __('noah-cms::noah-cms.activity.label.city'))
                            ->attributeLabel('district', __('noah-cms::noah-cms.activity.label.district'))
                            ->attributeLabel('address', __('noah-cms::noah-cms.activity.label.address'))
                            ->attributeLabel('pickup_store_no', __('noah-cms::noah-cms.activity.label.pickup_store_no'))
                            ->attributeLabel('pickup_store_name', __('noah-cms::noah-cms.activity.label.pickup_store_name'))
                            ->attributeLabel('pickup_store_address', __('noah-cms::noah-cms.activity.label.pickup_store_address'))
                            ->attributeLabel('pickup_retail_name', __('noah-cms::noah-cms.activity.label.pickup_retail_name'))
                            ->attributeLabel('postoffice_delivery_code', __('noah-cms::noah-cms.activity.label.postoffice_delivery_code'))
                            ->attributeLabel('provider', __('noah-cms::noah-cms.activity.label.provider'))
                            ->attributeLabel('status', __('noah-cms::noah-cms.activity.label.status'))
                            ->attributeLabel('price', __('noah-cms::noah-cms.activity.label.price'))
                            ->attributeLabel('discount', __('noah-cms::noah-cms.activity.label.discount'))
                            ->attributeLabel('total_price', __('noah-cms::noah-cms.activity.label.total_price'))
                            ->attributeLabel('donate_code', __('noah-cms::noah-cms.activity.label.donate_code'))
                            ->attributeLabel('company_title', __('noah-cms::noah-cms.activity.label.company_title'))
                            ->attributeLabel('company_code', __('noah-cms::noah-cms.activity.label.company_code'))
                            ->attributeLabel('type', __('noah-cms::noah-cms.activity.label.type')),
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
