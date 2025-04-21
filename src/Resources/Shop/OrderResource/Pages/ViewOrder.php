<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Filament\Resources\Pages\ViewRecord;
use Sharenjoy\NoahCms\Enums\DeliveryProvider;
use Sharenjoy\NoahCms\Enums\DeliveryType;
use Sharenjoy\NoahCms\Enums\InvoiceHolderType;
use Sharenjoy\NoahCms\Enums\InvoiceType;
use Sharenjoy\NoahCms\Models\OrderShipment;
use Sharenjoy\NoahCms\Resources\Shop\OrderResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahViewRecord;

class ViewOrder extends ViewRecord
{
    use NoahViewRecord;

    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('editShipment')
                ->label('編輯運送資訊')
                ->modalHeading('編輯運送資訊')
                ->icon('heroicon-o-truck')
                ->form([
                    Section::make('物流資訊')
                        ->extraAttributes(['style' => 'background-color: #f8f8f8'])
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    Select::make('provider')
                                        ->label(__('noah-cms::noah-cms.activity.label.delivery_provider'))
                                        ->options(DeliveryProvider::class)
                                        ->required()
                                        ->live(),

                                    Select::make('delivery_type')
                                        ->label(__('noah-cms::noah-cms.activity.label.delivery_type'))
                                        ->options(DeliveryType::class)
                                        ->required()
                                        ->live(),
                                ]),
                        ]),

                    Section::make('收件人資訊')
                        ->extraAttributes(['style' => 'background-color: #f8f8f8'])
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('calling_code')->label(__('noah-cms::noah-cms.activity.label.calling_code'))->required(),
                                    TextInput::make('mobile')->label(__('noah-cms::noah-cms.activity.label.mobile'))->required(),
                                ]),
                            Grid::make(1)
                                ->schema([
                                    TextInput::make('name')->label(__('noah-cms::noah-cms.activity.label.name'))->required(),
                                ]),
                        ]),

                    Section::make('運送地址')
                        ->extraAttributes(['style' => 'background-color: #f8f8f8'])
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('country')->label(__('noah-cms::noah-cms.activity.label.country'))->required(),
                                    TextInput::make('postcode')->label(__('noah-cms::noah-cms.activity.label.postcode'))->required(),
                                    TextInput::make('city')->label(__('noah-cms::noah-cms.activity.label.city'))->required(),
                                    TextInput::make('district')->label(__('noah-cms::noah-cms.activity.label.district'))->required(),
                                ]),
                            Grid::make(1)
                                ->schema([
                                    TextInput::make('address')->label(__('noah-cms::noah-cms.activity.label.address'))->required(),
                                ]),
                        ])->visible(fn(Get $get): bool => $get('delivery_type') == DeliveryType::Address->value),

                    Section::make('超商取貨資訊')
                        ->extraAttributes(['style' => 'background-color: #f8f8f8'])
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(1)
                                ->schema([
                                    TextInput::make('pickup_store_no')->label(__('noah-cms::noah-cms.activity.label.pickup_store_no'))->required(),
                                    TextInput::make('pickup_store_name')->label(__('noah-cms::noah-cms.activity.label.pickup_store_name'))->required(),
                                    TextInput::make('pickup_store_address')->label(__('noah-cms::noah-cms.activity.label.pickup_store_address'))->required(),
                                ]),
                        ])->visible(fn(Get $get): bool => $get('delivery_type') == DeliveryType::Pickinstore->value),

                    Section::make('門市取貨資訊')
                        ->extraAttributes(['style' => 'background-color: #f8f8f8'])
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(1)
                                ->schema([
                                    TextInput::make('pickup_retail_name')->label(__('noah-cms::noah-cms.activity.label.pickup_retail_name'))->required(),
                                ]),
                        ])->visible(fn(Get $get): bool => $get('delivery_type') == DeliveryType::Pickinretail->value),

                    Section::make('郵局取貨資訊')
                        ->extraAttributes(['style' => 'background-color: #f8f8f8'])
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(1)
                                ->schema([
                                    TextInput::make('postoffice_delivery_code')->label(__('noah-cms::noah-cms.activity.label.postoffice_delivery_code'))->required(),
                                ]),
                        ])->visible(fn(Get $get): bool => ($get('provider') == DeliveryProvider::Postoffice->value && $get('delivery_type') == DeliveryType::Address->value)),

                ])
                ->mountUsing(function (ComponentContainer $form, $record) {
                    $form->fill($record->shipment->toArray());
                })
                ->action(function (array $data, $record) {
                    $record->shipment->update($data);
                })
                ->requiresConfirmation(),

            Action::make('editInvoice')
                ->label('編輯發票資訊')
                ->modalHeading('編輯發票資訊')
                ->icon('heroicon-o-document-currency-dollar')
                ->form([
                    Section::make('發票類型')
                        ->extraAttributes(['style' => 'background-color: #f8f8f8'])
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(1)
                                ->schema([
                                    Select::make('type')
                                        ->label(__('noah-cms::noah-cms.invoice_type'))
                                        ->options(InvoiceType::class)
                                        ->required()
                                        ->live(),
                                    Select::make('holder_type')
                                        ->label(__('noah-cms::noah-cms.invoice_holder_type'))
                                        ->options(InvoiceHolderType::class)
                                        ->required()
                                        ->visible(fn(Get $get): bool => $get('type') == InvoiceType::Holder->value),
                                ]),
                        ]),

                    Section::make('載具資訊')
                        ->extraAttributes(['style' => 'background-color: #f8f8f8'])
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(1)
                                ->schema([
                                    TextInput::make('holder_code')
                                        ->required()
                                        ->label(__('noah-cms::noah-cms.invoice_holder_code')),
                                ]),
                        ])
                        ->visible(fn(Get $get): bool => $get('type') == InvoiceType::Holder->value),

                    Section::make('捐贈單位')
                        ->extraAttributes(['style' => 'background-color: #f8f8f8'])
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(1)
                                ->schema([
                                    Select::make('donate_code')
                                        ->label(__('noah-cms::noah-cms.invoice_donate_code'))
                                        ->required()
                                        ->options(config('noah-cms.donate_code')),
                                ]),
                        ])
                        ->visible(fn(Get $get): bool => $get('type') == InvoiceType::Donate->value),

                    Section::make('公司發票')
                        ->extraAttributes(['style' => 'background-color: #f8f8f8'])
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(1)
                                ->schema([
                                    TextInput::make('company_title')
                                        ->required()
                                        ->label(__('noah-cms::noah-cms.invoice_company_title')),
                                    TextInput::make('company_code')
                                        ->required()
                                        ->label(__('noah-cms::noah-cms.invoice_company_code')),
                                ]),
                        ])
                        ->visible(fn(Get $get): bool => $get('type') == InvoiceType::Company->value),
                ])
                ->mountUsing(function (ComponentContainer $form, $record) {
                    $form->fill($record->invoice->toArray());
                })
                ->action(function (array $data, $record) {
                    $record->invoice->update($data);
                })
                ->requiresConfirmation(),
            ActionGroup::make([]),
        ];
    }
}
