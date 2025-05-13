<?php

namespace Sharenjoy\NoahCms\Resources\CategoryResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Sharenjoy\NoahCms\Models\Category;
use Sharenjoy\NoahCms\Models\Menu;
use Sharenjoy\NoahCms\Resources\MenuResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahBaseRelationManager;

class MenusRelationManager extends RelationManager
{
    use NoahBaseRelationManager;

    protected static string $relationship = 'menus';

    protected static ?string $icon = 'heroicon-o-bars-arrow-down';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('noah-cms::noah-cms.menu');
    }

    protected static function getRecordLabel(): ?string
    {
        return __('noah-cms::noah-cms.menu');
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->menus->count();
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema(\Sharenjoy\NoahCms\Utils\Form::make(Menu::class, $form->getOperation()));
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn(Menu $record): string => "({$record->id}) {$record->title}")
            ->heading(__('noah-cms::noah-cms.menu'))
            ->columns(array_merge(static::getTableStartColumns(MenuResource::class), \Sharenjoy\NoahCms\Utils\Table::make(Menu::class)))
            ->filters(\Sharenjoy\NoahCms\Utils\Filter::make(Menu::class, Category::class))
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
