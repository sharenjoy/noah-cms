<?php

namespace Sharenjoy\NoahCms\Resources\MenuResource\RelationManagers;

use Sharenjoy\NoahCms\Models\Category;
use Sharenjoy\NoahCms\Models\Menu;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'categories';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('noah-cms::noah-cms.category');
    }

    protected static function getRecordLabel(): ?string
    {
        return __('noah-cms::noah-cms.category');
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema(\Sharenjoy\NoahCms\Utils\Form::make(Category::class, $form->getOperation()));
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn(Category $record): string => "({$record->id}) {$record->title}")
            ->heading(__('noah-cms::noah-cms.category'))
            ->columns(\Sharenjoy\NoahCms\Utils\Table::make(Category::class))
            ->filters(\Sharenjoy\NoahCms\Utils\Filter::make(Category::class, Menu::class))
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
