<?php

namespace Sharenjoy\NoahCms\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;
use Sharenjoy\NoahCms\Models\User;
use Sharenjoy\NoahCms\Resources\Traits\NoahBaseResource;
use Sharenjoy\NoahCms\Resources\UserResource\Pages;
use Sharenjoy\NoahCms\Resources\UserResource\RelationManagers\AddressesRelationManager;
use Sharenjoy\NoahCms\Resources\UserResource\RelationManagers\ObjectivesRelationManager;
use Sharenjoy\NoahCms\Resources\UserResource\RelationManagers\OrdersRelationManager;
use Sharenjoy\NoahCms\Resources\UserResource\RelationManagers\PointCoinMutationsRelationManager;
use Sharenjoy\NoahCms\Resources\UserResource\RelationManagers\RolesRelationManager;
use Sharenjoy\NoahCms\Resources\UserResource\RelationManagers\ShoppingMoneyCoinMutationsRelationManager;
use Sharenjoy\NoahCms\Resources\UserResource\RelationManagers\UserCouponsRelationManager;
use Sharenjoy\NoahCms\Resources\UserResource\RelationManagers\UserLevelStatusesRelationManager;

class UserResource extends Resource implements HasShieldPermissions
{
    use NoahBaseResource;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?int $navigationSort = 49;

    public static function getNavigationGroup(): ?string
    {
        return Utils::isResourceNavigationGroupEnabled()
            ? __('filament-shield::filament-shield.nav.group')
            : '';
    }

    public static function getModelLabel(): string
    {
        return __('noah-cms::noah-cms.user');
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
                Impersonate::make()->iconSize('sm'),
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
            OrdersRelationManager::class,
            UserCouponsRelationManager::class,
            ObjectivesRelationManager::class,
            UserLevelStatusesRelationManager::class,
            PointCoinMutationsRelationManager::class,
            ShoppingMoneyCoinMutationsRelationManager::class,
            AddressesRelationManager::class,
            RolesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return array_merge(static::getCommonPermissionPrefixes(), []);
    }
}
