<?php

namespace Sharenjoy\NoahCms\Resources\CategoryResource\RelationManagers;

use Sharenjoy\NoahCms\Models\Category;
use Sharenjoy\NoahCms\Models\Product;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('noah-cms::noah-cms.product');
    }

    protected static function getRecordLabel(): ?string
    {
        return __('noah-cms::noah-cms.product');
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema(\Sharenjoy\NoahCms\Utils\Form::make(Product::class, $form->getOperation()));
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn(Product $record): string => "({$record->id}) {$record->title}")
            ->heading(__('noah-cms::noah-cms.product'))
            ->columns(\Sharenjoy\NoahCms\Utils\Table::make(Product::class))
            ->filters(\Sharenjoy\NoahCms\Utils\Filter::make(Product::class, Category::class))
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()->preloadRecordSelect()->recordSelectSearchColumns(['title', 'description', 'slug'])->multiple(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
