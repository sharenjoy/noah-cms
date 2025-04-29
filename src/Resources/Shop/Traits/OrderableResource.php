<?php

namespace Sharenjoy\NoahCms\Resources\Shop\Traits;

use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use RalphJSmit\Filament\Activitylog\Infolists\Components\Timeline;
use Sharenjoy\NoahCms\Actions\Shop\DisplayOrderShipmentDetail;
use Sharenjoy\NoahCms\Enums\OrderStatus;
use Sharenjoy\NoahCms\Infolists\Components\OrderEntry;
use Sharenjoy\NoahCms\Models\Invoice;
use Sharenjoy\NoahCms\Models\InvoicePrice;
use Sharenjoy\NoahCms\Models\OrderItem;
use Sharenjoy\NoahCms\Models\OrderShipment;
use Sharenjoy\NoahCms\Models\Transaction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\RelationManagers\InvoicePricesRelationManager;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\RelationManagers\OrderItemsRelationManager;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\RelationManagers\OrderShipmentsRelationManager;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\RelationManagers\TransactionsRelationManager;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\RelationManagers\UserRelationManager;
use Sharenjoy\NoahCms\Resources\Traits\NoahBaseResource;
use Spatie\Activitylog\Models\Activity;

trait OrderableResource
{
    use NoahBaseResource;

    public static function getNavigationGroup(): ?string
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
                //     ->label(__('noah-cms::noah-cms.transaction_status'))
                //     ->options(collect(TransactionStatus::cases())
                //         ->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
                //         ->toArray())
                //     // ->relationship('transaction', 'status')
                //     ->query(function (Builder $query, ?string $value = null) {
                //         if (! filled($value)) {
                //             return $query; // 直接跳過，不加條件
                //         }
                //         // dd($value);
                //         return $query->whereHas('transaction', fn($q) => $q->where('status', $value));
                //     }),
                // SelectFilter::make('invoice')
                //     ->label(__('noah-cms::noah-cms.invoice_type'))
                //     ->relationship('invoice', 'typeable')
                //     ->options(InvoiceType::toArray()),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('view_order_info_list')
                        ->icon('heroicon-o-document-text')
                        ->label(__('noah-cms::noah-cms.view_order_info_list'))
                        ->url(function ($record) {
                            return self::getUrl('info-list', ['record' => $record]);
                        }),
                    Tables\Actions\Action::make('view_order_picking_list')
                        ->icon('heroicon-o-document-text')
                        ->label(__('noah-cms::noah-cms.view_order_picking_list'))
                        ->url(function ($record) {
                            return self::getUrl('picking-list', ['record' => $record]);
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(array_merge(static::getBulkActions(), [])),
            ])
            ->reorderable(false);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make(__('noah-cms::noah-cms.order'))
                    ->schema([
                        OrderEntry::make(''),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
                // \Filament\Infolists\Components\Section::make(__('noah-cms::noah-cms.order_items'))
                //     ->schema([
                //         \Sharenjoy\NoahCms\Infolists\Components\OrderItemsEntry::make(''),
                //     ])
                //     ->collapsible()
                //     ->columnSpanFull(),
                Section::make(__('noah-cms::noah-cms.timeline'))
                    ->schema([
                        Timeline::make()
                            ->searchable()
                            ->hiddenLabel()
                            ->withRelations(['items', 'invoice', 'transaction', 'invoicePrices', 'shipment'])
                            ->eventDescriptions(
                                descriptions: [
                                    'updated-order-status' => function (Activity $activity) {
                                        $options = OrderStatus::getShowableOptions();
                                        $log = "**{$activity->causer->name}** 更新了 **狀態** 從 " . $options[$activity->properties['old']['status']] . ' 變更為 **' . $options[$activity->properties['attributes']['status']] . '**';
                                        if ($activity->properties['notes'] ?? null) {
                                            $log .= ' **備註** ' . $activity->properties['notes'];
                                        }
                                        return $log;
                                    },
                                ]
                            )
                            ->itemIcon('updated-order-status', 'heroicon-o-arrows-right-left')
                            ->itemIconColor('updated-order-status', 'warning')
                            ->getRecordTitleUsing(OrderItem::class, function (OrderItem $model) {
                                return $model->product->title . '(' . implode(',', $model->product_details['spec_detail_name'] ?? []) . ') x ' . $model->quantity . ' ' . __('noah-cms::noah-cms.activity.label.item_subtotal') . ' ' . currency_format($model->subtotal, $model->currency);
                            })
                            ->getRecordTitleUsing(Invoice::class, function (Invoice $model) {
                                return $model->type->getLabel();
                            })
                            ->getRecordTitleUsing(InvoicePrice::class, function (InvoicePrice $model) {
                                return $model->type->getLabel() . ' ' . $model->value;
                            })
                            ->getRecordTitleUsing(Transaction::class, function (Transaction $model) {
                                return $model->status->getLabel() . ' ' . $model->provider->getLabel() . ' ' . $model->payment_method->getLabel() . ' ' . currency_format($model->total_price, $model->currency);
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
                            ->attributeLabel('holder_code', __('noah-cms::noah-cms.activity.label.holder_code'))
                            ->attributeLabel('holder_type', __('noah-cms::noah-cms.activity.label.holder_type'))
                            ->attributeLabel('company_title', __('noah-cms::noah-cms.activity.label.company_title'))
                            ->attributeLabel('company_code', __('noah-cms::noah-cms.activity.label.company_code'))
                            ->attributeLabel('type', __('noah-cms::noah-cms.activity.label.type'))
                            ->attributeLabel('payment_method', __('noah-cms::noah-cms.activity.label.payment_method')),
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
            // OrderShipmentsRelationManager::class,
            // TransactionsRelationManager::class,
            UserRelationManager::class,
        ];
    }
}
