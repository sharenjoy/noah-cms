<?php

namespace Sharenjoy\NoahCms\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Sharenjoy\NoahCms\Resources\CategoryResource\Pages;
use Sharenjoy\NoahCms\Resources\CategoryResource\RelationManagers\MenusRelationManager;
use Sharenjoy\NoahCms\Resources\CategoryResource\RelationManagers\PostsRelationManager;
use Sharenjoy\NoahCms\Resources\CategoryResource\RelationManagers\ProductsRelationManager;
use Sharenjoy\NoahCms\Resources\Traits\NoahBaseResource;

class CategoryResource extends Resource implements HasShieldPermissions
{
    use NoahBaseResource;

    // Model setting is done in noah-cms config file
    // protected static ?string $model;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?int $navigationSort = 32;

    public static function getNavigationGroup(): string
    {
        return __('noah-cms::noah-cms.resource');
    }

    public static function getModelLabel(): string
    {
        return __('noah-cms::noah-cms.categories');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema(\Sharenjoy\NoahCms\Utils\Form::make(static::getModel(), $form->getOperation()));
    }

    public static function table(Table $table): Table
    {
        $table = static::chainTableFunctions($table);
        return $table
            ->columns(array_merge(static::getTableStartColumns(), \Sharenjoy\NoahCms\Utils\Table::make(static::getModel())))
            ->filters(\Sharenjoy\NoahCms\Utils\Filter::make(static::getModel()))
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ActionGroup::make(array_merge(static::getTableActions(), [])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(array_merge(static::getBulkActions(), [])),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // ProductsRelationManager::class, //** NoahShop CAN OPEN
            PostsRelationManager::class,
            MenusRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
            'view' => Pages\ViewCategory::route('/{record}'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return array_merge(static::getCommonPermissionPrefixes(), []);
    }
}
