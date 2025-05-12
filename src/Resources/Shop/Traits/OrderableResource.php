<?php

namespace Sharenjoy\NoahCms\Resources\Shop\Traits;

use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use RalphJSmit\Filament\Activitylog\Infolists\Components\Timeline;
use Sharenjoy\NoahCms\Actions\Shop\DisplayOrderShipmentDetail;
use Sharenjoy\NoahCms\Enums\DeliveryProvider;
use Sharenjoy\NoahCms\Enums\DeliveryType;
use Sharenjoy\NoahCms\Enums\InvoiceType;
use Sharenjoy\NoahCms\Enums\OrderShipmentStatus;
use Sharenjoy\NoahCms\Enums\OrderStatus;
use Sharenjoy\NoahCms\Enums\PaymentMethod;
use Sharenjoy\NoahCms\Enums\PaymentProvider;
use Sharenjoy\NoahCms\Enums\TransactionStatus;
use Sharenjoy\NoahCms\Infolists\Components\OrderEntry;
use Sharenjoy\NoahCms\Models\Invoice;
use Sharenjoy\NoahCms\Models\InvoicePrice;
use Sharenjoy\NoahCms\Models\OrderItem;
use Sharenjoy\NoahCms\Models\OrderShipment;
use Sharenjoy\NoahCms\Models\Transaction;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\RelationManagers\InvoicePricesRelationManager;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource\RelationManagers\OrderItemsRelationManager;
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
        return parent::getEloquentQuery()->with(['user.orders', 'user.validOrders', 'user.tags', 'shipment', 'shipments', 'invoice', 'transaction', 'items']);
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
                Filter::make('order_status')
                    ->label(__('noah-cms::noah-cms.order_status'))
                    ->form([
                        Select::make('shipment')
                            ->label(__('noah-cms::noah-cms.order_shipment_status'))
                            ->options(OrderShipmentStatus::toArray()),
                        Select::make('delivery_provider')
                            ->label(__('noah-cms::noah-cms.delivery_provider'))
                            ->options(DeliveryProvider::toArray()),
                        Select::make('delivery_type')
                            ->label(__('noah-cms::noah-cms.activity.label.delivery_type'))
                            ->options(DeliveryType::toArray()),
                        Select::make('transaction')
                            ->label(__('noah-cms::noah-cms.transaction_status'))
                            ->options(TransactionStatus::toArray()),
                        Select::make('payment_provider')
                            ->label(__('noah-cms::noah-cms.payment_provider'))
                            ->options(PaymentProvider::toArray()),
                        Select::make('payment_method')
                            ->label(__('noah-cms::noah-cms.activity.label.payment_method'))
                            ->options(PaymentMethod::toArray()),
                        Select::make('invoice')
                            ->label(__('noah-cms::noah-cms.invoice_type'))
                            ->options(InvoiceType::toArray()),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['shipment'] ?? null) {
                            $query->whereHas('shipment', function (Builder $q) use ($data) {
                                $q->where('status', $data['shipment']);
                            });
                        }
                        if ($data['delivery_type'] ?? null) {
                            $query->whereHas('shipment', function (Builder $q) use ($data) {
                                $q->where('delivery_type', $data['delivery_type']);
                            });
                        }
                        if ($data['delivery_provider'] ?? null) {
                            $query->whereHas('shipment', function (Builder $q) use ($data) {
                                $q->where('provider', $data['delivery_provider']);
                            });
                        }
                        if ($data['transaction'] ?? null) {
                            $query->whereHas('transaction', function (Builder $q) use ($data) {
                                $q->where('status', $data['transaction']);
                            });
                        }
                        if ($data['payment_method'] ?? null) {
                            $query->whereHas('transaction', function (Builder $q) use ($data) {
                                $q->where('payment_method', $data['payment_method']);
                            });
                        }
                        if ($data['payment_provider'] ?? null) {
                            $query->whereHas('transaction', function (Builder $q) use ($data) {
                                $q->where('provider', $data['payment_provider']);
                            });
                        }
                        if ($data['invoice'] ?? null) {
                            $query->whereHas('invoice', function (Builder $q) use ($data) {
                                $q->where('type', $data['invoice']);
                            });
                        }

                        return $query;
                    })
                    ->indicateUsing(function (array $data): ?string {
                        $shipment = $data['shipment'] ?? null;
                        $deliveryType = $data['delivery_type'] ?? null;
                        $deliveryProvider = $data['delivery_provider'] ?? null;
                        $transaction = $data['transaction'] ?? null;
                        $paymentMethod = $data['payment_method'] ?? null;
                        $paymentProvider = $data['payment_provider'] ?? null;
                        $invoice = $data['invoice'] ?? null;

                        $indicateString = [];
                        if ($shipment) {
                            $indicateString[] = __('noah-cms::noah-cms.order_shipment_status') . ': ' . OrderShipmentStatus::tryFrom($shipment)->getLabel();
                        }
                        if ($deliveryType) {
                            $indicateString[] = __('noah-cms::noah-cms.activity.label.delivery_type') . ': ' . DeliveryType::tryFrom($deliveryType)->getLabel();
                        }
                        if ($deliveryProvider) {
                            $indicateString[] = __('noah-cms::noah-cms.delivery_provider') . ': ' . DeliveryProvider::tryFrom($deliveryProvider)->getLabel();
                        }
                        if ($transaction) {
                            $indicateString[] = __('noah-cms::noah-cms.transaction_status') . ': ' . TransactionStatus::tryFrom($transaction)->getLabel();
                        }
                        if ($paymentMethod) {
                            $indicateString[] = __('noah-cms::noah-cms.activity.label.payment_method') . ': ' . PaymentMethod::tryFrom($paymentMethod)->getLabel();
                        }
                        if ($paymentProvider) {
                            $indicateString[] = __('noah-cms::noah-cms.payment_provider') . ': ' . PaymentProvider::tryFrom($paymentProvider)->getLabel();
                        }
                        if ($invoice) {
                            $indicateString[] = __('noah-cms::noah-cms.invoice_type') . ': ' . InvoiceType::tryFrom($invoice)->getLabel();
                        }
                        if (count($indicateString)) {
                            return implode(', ', $indicateString);
                        }

                        return null;
                    }),
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
