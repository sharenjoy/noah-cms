<?php

namespace Sharenjoy\NoahCms\Resources\Shop\OrderResource\Pages\Actions;

use Filament\Actions\Action;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Sharenjoy\NoahCms\Actions\Shop\OrderStatusRedirector;
use Sharenjoy\NoahCms\Actions\Shop\OrderStatusUpdater;
use Sharenjoy\NoahCms\Enums\OrderStatus;

class UpdateOrderStatusAction
{
    public static function make()
    {
        return Action::make('updateOrderStatusAction')
            ->label('更新訂單狀態')
            ->modalHeading('更新訂單狀態')
            ->color('primary')
            ->icon('heroicon-o-arrows-right-left')
            ->form([
                Section::make('訂單狀態')
                    ->extraAttributes(['style' => 'background-color: #f8f8f8'])
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Select::make('status')
                                    ->label(__('noah-cms::noah-cms.order_status'))
                                    ->options(OrderStatus::getShowableOptions())
                                    ->required(),

                                Textarea::make('content')->rows(2)->label(__('noah-cms::noah-cms.activity.label.status_notes')),
                            ]),
                    ]),
            ])
            ->mountUsing(function (ComponentContainer $form, $record) {
                $form->fill($record->toArray());
            })
            ->action(function (array $data, $record) {

                $statusEnum = OrderStatus::tryFrom($data['status']);

                if (! $statusEnum) {
                    Notification::make()
                        ->title('無效的訂單狀態')
                        ->danger()
                        ->send();
                }

                $result = OrderStatusUpdater::run($record, $statusEnum, $data['content'] ?? null);

                if ($result === true) {
                    return OrderStatusRedirector::run($record);
                }
            })
            ->requiresConfirmation();
    }
}
