<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions;

use Filament\Actions\Action;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Sharenjoy\NoahCms\Actions\Shop\FetchAddressRelatedSelectOptions;
use Sharenjoy\NoahCms\Actions\Shop\FetchCountryRelatedSelectOptions;
use Sharenjoy\NoahCms\Enums\DeliveryProvider;
use Sharenjoy\NoahCms\Enums\DeliveryType;

class EditShipmentAction
{
    public static function make()
    {
        return Action::make('editShipment')
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
                                    ->label(__('noah-cms::noah-cms.activity.label.provider'))
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
                                Select::make('calling_code')
                                    ->label(__('noah-cms::noah-cms.activity.label.calling_code'))
                                    ->options(FetchCountryRelatedSelectOptions::run('calling_code'))
                                    ->searchable()
                                    ->required(),
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
                                Select::make('country')
                                    ->label(__('noah-cms::noah-cms.activity.label.country'))
                                    ->options(FetchCountryRelatedSelectOptions::run('country'))
                                    ->searchable()
                                    ->required()
                                    ->live(),
                                TextInput::make('postcode')->label(__('noah-cms::noah-cms.activity.label.postcode'))->required(),
                                Select::make('city')
                                    ->label(__('noah-cms::noah-cms.activity.label.city'))
                                    ->visible(fn(Get $get): bool => $get('country') == 'Taiwan')
                                    ->options(FetchAddressRelatedSelectOptions::run('city'))
                                    ->searchable()
                                    ->required()
                                    ->live(),
                                Select::make('district')
                                    ->label(__('noah-cms::noah-cms.activity.label.district'))
                                    ->options(fn(Get $get) => FetchAddressRelatedSelectOptions::run('district', $get('city')))
                                    ->searchable()
                                    ->required()
                                    ->visible(fn(Get $get): bool => $get('country') == 'Taiwan'),
                            ]),
                        Grid::make(1)
                            ->schema([
                                Textarea::make('address')->rows(2)->label(__('noah-cms::noah-cms.activity.label.address'))->required(),
                            ]),
                    ])->visible(fn(Get $get): bool => $get('delivery_type') == DeliveryType::Address->value),

                Section::make('超商取貨資訊')
                    ->extraAttributes(['style' => 'background-color: #f8f8f8'])
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('pickup_store_no')->label(__('noah-cms::noah-cms.activity.label.pickup_store_no'))->required(),
                                TextInput::make('pickup_store_name')->label(__('noah-cms::noah-cms.activity.label.pickup_store_name'))->required(),
                            ]),
                        Grid::make(1)
                            ->schema([
                                Textarea::make('pickup_store_address')->rows(2)->label(__('noah-cms::noah-cms.activity.label.pickup_store_address'))->required(),
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
            ->requiresConfirmation();
    }
}
