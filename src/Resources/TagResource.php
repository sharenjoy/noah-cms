<?php

namespace Sharenjoy\NoahCms\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Sharenjoy\NoahCms\Resources\TagResource\Pages;
use Sharenjoy\NoahCms\Resources\TagResource\RelationManagers\PostsRelationManager;
use Sharenjoy\NoahCms\Resources\TagResource\RelationManagers\ProductsRelationManager;
use Sharenjoy\NoahCms\Resources\TagResource\RelationManagers\UsersRelationManager;
use Sharenjoy\NoahCms\Resources\Traits\NoahBaseResource;

class TagResource extends Resource implements HasShieldPermissions
{
    use NoahBaseResource;

    // Model setting is done in noah-cms config file
    // protected static ?string $model;

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    protected static ?int $navigationSort = 38;

    public static function getNavigationGroup(): string
    {
        return __('noah-cms::noah-cms.resource');
    }

    public static function getModelLabel(): string
    {
        return __('noah-cms::noah-cms.tag');
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
            PostsRelationManager::class,
            // ProductsRelationManager::class,
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
            'view' => Pages\ViewTag::route('/{record}'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return array_merge(static::getCommonPermissionPrefixes(), []);
    }
}
