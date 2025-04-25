<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions;

use Filament\Actions\Action;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Sharenjoy\NoahCms\Enums\PaymentMethod;
use Sharenjoy\NoahCms\Enums\TransactionProvider;

class EditTransactionAction
{
    public static function make()
    {
        return Action::make('editTransaction')
            ->label('編輯付款資訊')
            ->modalHeading('編輯付款資訊')
            ->icon('heroicon-o-cube-transparent')
            ->form([
                Section::make('付款方式')
                    ->extraAttributes(['style' => 'background-color: #f8f8f8'])
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('provider')
                                    ->label(__('noah-cms::noah-cms.activity.label.provider'))
                                    ->options(TransactionProvider::class)
                                    ->required()
                                    ->live(),

                                Select::make('payment_method')
                                    ->label(__('noah-cms::noah-cms.activity.label.payment_method'))
                                    ->options(PaymentMethod::class)
                                    ->required()
                                    ->live(),
                            ]),
                    ]),

                Section::make('ATM')
                    ->extraAttributes(['style' => 'background-color: #f8f8f8'])
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('atm_code')
                                    ->required()
                                    ->label(__('noah-cms::noah-cms.activity.label.atm_code')),
                                TextInput::make('expired_at')
                                    ->required()
                                    ->label(__('noah-cms::noah-cms.activity.label.expired_at')),
                            ]),
                    ])
                    ->visible(fn(Get $get): bool => $get('payment_method') == PaymentMethod::ATM->value),
            ])
            ->mountUsing(function (ComponentContainer $form, $record) {
                $form->fill($record->transaction->toArray());
            })
            ->action(function (array $data, $record) {
                $record->transaction->update($data);
            })
            ->requiresConfirmation();
    }
}
