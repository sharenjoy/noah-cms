<?php

namespace Sharenjoy\NoahCms\Resources\ProductResource\RelationManagers;

use Filament\Tables\Actions\Action;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Sharenjoy\NoahCms\Models\ProductSpecification;

class ProductSpecificationsRelationManager extends RelationManager
{
    protected static string $relationship = 'productSpecifications';

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
            ->schema(\Sharenjoy\NoahCms\Utils\Form::make(ProductSpecification::class, $form->getOperation()));
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn(ProductSpecification $record): string => "({$record->id}) {$record->title}")
            ->heading(__('noah-cms::noah-cms.specification'))
            ->columns(\Sharenjoy\NoahCms\Utils\Table::make(ProductSpecification::class))
            ->filters(\Sharenjoy\NoahCms\Utils\Filter::make(ProductSpecification::class))
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            );;
    }
}
