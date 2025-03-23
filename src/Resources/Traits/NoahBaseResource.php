<?php

namespace Sharenjoy\NoahCms\Resources\Traits;

use Filament\Resources\Concerns\Translatable;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\EloquentSortable\SortableTrait;

trait NoahBaseResource
{
    use Translatable;

    public static function getEloquentQuery(): Builder
    {
        if (in_array(SoftDeletes::class, class_uses(static::getModel()))) {
            return parent::getEloquentQuery()
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
        }

        return parent::getEloquentQuery();
    }

    protected static function chainTableFunctions(Table $table): Table
    {
        if (in_array(SortableTrait::class, class_uses(static::getModel()))) {
            $table
                ->reorderable('order_column')
                ->defaultSort('order_column')
                ->reorderRecordsTriggerAction(
                    fn(Action $action, bool $isReordering) => $action
                        ->button()
                        ->label($isReordering ? __('Reordering completed') : __('Start reordering')),
                );
        }

        return $table;
    }

    protected static function getTableActions(): array
    {
        $actions[] = ViewAction::make();
        $actions[] = EditAction::make();

        if (method_exists(static::getModel(), 'getReplicateAction')) {
            $actions[] = app(static::getModel())->getReplicateAction('table');
        }

        $actions[] = DeleteAction::make();
        if (in_array(SoftDeletes::class, class_uses(static::getModel()))) {
            $actions[] = RestoreAction::make();
            $actions[] = ForceDeleteAction::make();
        }

        return $actions;
    }

    protected static function getBulkActions(): array
    {
        $actions[] = DeleteBulkAction::make();
        if (in_array(SoftDeletes::class, class_uses(static::getModel()))) {
            $actions[] = RestoreBulkAction::make();
            $actions[] = ForceDeleteBulkAction::make();
        }

        return $actions;
    }

    protected static function getCommonPermissionPrefixes(): array
    {
        $permissions = [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];

        if (method_exists(static::getModel(), 'getReplicateAction')) {
            $permissions = array_merge($permissions, [
                'replicate',
            ]);
        }

        if (in_array(SoftDeletes::class, class_uses(static::getModel()))) {
            $permissions = array_merge($permissions, [
                'restore',
                'restore_any',
                'force_delete',
                'force_delete_any',
            ]);
        }

        if (in_array(SortableTrait::class, class_uses(static::getModel()))) {
            $permissions = array_merge($permissions, [
                'reorder',
            ]);
        }

        return $permissions;
    }
}
