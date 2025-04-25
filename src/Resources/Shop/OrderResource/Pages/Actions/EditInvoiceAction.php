<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions;

use Filament\Actions\Action;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Sharenjoy\NoahCms\Enums\InvoiceHolderType;
use Sharenjoy\NoahCms\Enums\InvoiceType;

class EditInvoiceAction
{
    public static function make()
    {
        return Action::make('editInvoice')
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
            ->requiresConfirmation();
    }
}
