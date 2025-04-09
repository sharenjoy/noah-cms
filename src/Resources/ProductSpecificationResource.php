<?php

namespace Sharenjoy\NoahCms\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Sharenjoy\NoahCms\Models\ProductSpecification;
use Sharenjoy\NoahCms\Resources\ProductSpecificationResource\Pages;
use Sharenjoy\NoahCms\Resources\ProductSpecificationResource\RelationManagers\ProductRelationManager;
use Sharenjoy\NoahCms\Resources\Traits\NoahBaseResource;

class ProductSpecificationResource extends Resource implements HasShieldPermissions
{
    use NoahBaseResource;

    protected static ?string $model = ProductSpecification::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return __('noah-cms::noah-cms.product');
    }

    public static function getModelLabel(): string
    {
        return __('noah-cms::noah-cms.specification');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema(\Sharenjoy\NoahCms\Utils\Form::make(static::getModel(), $form->getOperation()));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(\Sharenjoy\NoahCms\Utils\Table::make(static::getModel()))
            ->filters(\Sharenjoy\NoahCms\Utils\Filter::make(static::getModel()))
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ])
            ->groups([
                Group::make('product_id')->label(__('noah-cms::noah-cms.product_title'))->collapsible(),
            ])
            ->defaultSort('created_at');
    }

    public static function getRelations(): array
    {
        return [
            ProductRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductSpecifications::route('/'),
            // 'create' => Pages\CreateProductSpecification::route('/create'),
            // 'view' => Pages\ViewProductSpecification::route('/{record}'),
            'edit' => Pages\EditProductSpecification::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'update',
        ];
    }
}
