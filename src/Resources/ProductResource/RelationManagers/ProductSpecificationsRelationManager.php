<?php

namespace Sharenjoy\NoahCms\Resources\ProductResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Sharenjoy\NoahCms\Actions\StoreRecordBackToProductSpecs;
use Sharenjoy\NoahCms\Models\ProductSpecification;

class ProductSpecificationsRelationManager extends RelationManager
{
    protected static string $relationship = 'specifications';

    protected static ?string $icon = 'heroicon-o-square-3-stack-3d';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('noah-cms::noah-cms.specification');
    }

    protected static function getRecordLabel(): ?string
    {
        return __('noah-cms::noah-cms.specification');
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema(\Sharenjoy\NoahCms\Utils\Form::make(ProductSpecification::class, $form->getOperation(), ownerRecord: $this->getOwnerRecord()));
    }

    public function table(Table $table): Table
    {
        $parentRecord = $this->getOwnerRecord();
        $headerActions = [];

        if (! $parentRecord['is_single_spec']) {
            $headerActions[] = Tables\Actions\CreateAction::make()
                ->mutateFormDataUsing(function (Tables\Actions\CreateAction $action, array $data): array {
                    try {
                        StoreRecordBackToProductSpecs::run($data['spec_detail_name'], $this->getOwnerRecord(), 'create');
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title(__('noah-cms::noah-cms.error'))
                            ->body($e->getMessage())
                            ->danger()
                            ->send();

                        $action->halt();
                    }

                    return $data;
                });
        }

        return $table
            ->recordTitle(fn(ProductSpecification $record): string => "({$record->id}) {$record->title}")
            ->heading(__('noah-cms::noah-cms.specification'))
            ->columns(\Sharenjoy\NoahCms\Utils\Table::make(ProductSpecification::class))
            ->filters(\Sharenjoy\NoahCms\Utils\Filter::make(ProductSpecification::class))
            ->headerActions($headerActions)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (Tables\Actions\EditAction $action, array $data, ProductSpecification $record): array {
                        try {
                            StoreRecordBackToProductSpecs::run($data['spec_detail_name'] ?? [], $this->getOwnerRecord(), 'edit', $record);
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title(__('noah-cms::noah-cms.error'))
                                ->body($e->getMessage())
                                ->danger()
                                ->send();

                            $action->halt();
                        }

                        return $data;
                    }),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order_column')
            ->defaultSort('order_column')
            ->reorderRecordsTriggerAction(
                fn(Action $action, bool $isReordering) => $action
                    ->button()
                    ->label($isReordering ? __('noah-cms::noah-cms.reordering_completed') : __('noah-cms::noah-cms.start_reordering')),
            );
    }
}
