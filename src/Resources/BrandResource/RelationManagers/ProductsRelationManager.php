<?php

namespace Sharenjoy\NoahCms\Resources\BrandResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Sharenjoy\NoahCms\Models\Product;
use Sharenjoy\NoahCms\Resources\ProductResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahBaseRelationManager;

class ProductsRelationManager extends RelationManager
{
    use NoahBaseRelationManager;

    protected static string $relationship = 'products';

    protected static ?string $icon = 'heroicon-o-square-3-stack-3d';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('noah-cms::noah-cms.product');
    }

    protected static function getRecordLabel(): ?string
    {
        return __('noah-cms::noah-cms.product');
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->products->count();
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
            ->columns(array_merge(static::getTableStartColumns(ProductResource::class), \Sharenjoy\NoahCms\Utils\Table::make(Product::class)))
            ->filters(\Sharenjoy\NoahCms\Utils\Filter::make(Product::class))
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
            ]);
    }
}
