<?php

namespace Sharenjoy\NoahCms\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;
use Sharenjoy\NoahCms\Actions\Shop\RoleCan;
use Sharenjoy\NoahCms\Models\Role;
use Sharenjoy\NoahCms\Models\User;
use Sharenjoy\NoahCms\Models\UserLevel;
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
        $table = static::chainTableFunctions($table);
        return $table
            ->columns(array_merge(static::getTableStartColumns(), \Sharenjoy\NoahCms\Utils\Table::make(static::getModel())))
            ->filters(array_merge([
                Filter::make('userLevels')
                    ->form([
                        Select::make('userLevels')
                            ->label(__('noah-cms::noah-cms.user_level'))
                            ->options(UserLevel::all()->pluck('title', 'id'))
                            ->prefixIcon('heroicon-o-chart-bar')
                            ->multiple()
                            ->searchable(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        $query->when($data['userLevels'], function ($query, $userLevels) {
                            return $query->whereHas('userLevel', fn($query) => $query->whereIn('user_level_id', $userLevels));
                        });
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if ($data['userLevels'] ?? null) {
                            return __('noah-cms::noah-cms.user_level') . ': ' . implode(', ', UserLevel::whereIn('id', $data['userLevels'])->get()->pluck('title')->toArray());
                        }

                        return null;
                    }),
                Filter::make('roles')
                    ->form([
                        Select::make('roles')
                            ->label(__('noah-cms::noah-cms.role'))
                            ->options(Role::all()->pluck('name', 'id'))
                            ->prefixIcon('heroicon-o-shield-check')
                            ->multiple()
                            ->searchable(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        $query->when($data['roles'], function ($query, $roles) {
                            return $query->whereHas('roles', fn($query) => $query->whereIn('roles.id', $roles));
                        });
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if ($data['roles'] ?? null) {
                            return __('noah-cms::noah-cms.role') . ': ' . implode(', ', Role::whereIn('id', $data['roles'])->get()->pluck('name')->toArray());
                        }

                        return null;
                    }),
            ], \Sharenjoy\NoahCms\Utils\Filter::make(static::getModel())))
            ->actions([
                Impersonate::make()->iconSize('sm')->visible(fn() => RoleCan::run(role: 'super_admin')),
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
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return array_merge(static::getCommonPermissionPrefixes(), []);
    }
}
