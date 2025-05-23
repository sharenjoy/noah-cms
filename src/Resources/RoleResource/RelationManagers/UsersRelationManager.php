<?php

namespace Sharenjoy\NoahCms\Resources\RoleResource\RelationManagers;

use Sharenjoy\NoahCms\Models\User;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $icon = 'heroicon-o-user-circle';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('noah-cms::noah-cms.user');
    }

    protected static function getRecordLabel(): ?string
    {
        return __('noah-cms::noah-cms.user');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn(User $record): string => "({$record->id}) {$record->name}\r{$record->email}")
            ->heading(__('noah-cms::noah-cms.user'))
            ->columns(\Sharenjoy\NoahCms\Utils\Table::make(User::class))
            ->filters(\Sharenjoy\NoahCms\Utils\Filter::make(User::class, Role::class))
            ->headerActions([
                Tables\Actions\AttachAction::make()->preloadRecordSelect()->recordSelectSearchColumns(['name', 'email'])->multiple(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
