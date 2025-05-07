<?php

namespace Sharenjoy\NoahCms\Resources\UserResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Sharenjoy\NoahCms\Models\Address;
use Sharenjoy\NoahCms\Models\User;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $icon = 'heroicon-o-map-pin';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('noah-cms::noah-cms.address');
    }

    protected static function getRecordLabel(): ?string
    {
        return __('noah-cms::noah-cms.address');
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema(\Sharenjoy\NoahCms\Utils\Form::make(Address::class, $form->getOperation()));
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn(Address $record): string => "({$record->id}) {$record->title}")
            ->heading(__('noah-cms::noah-cms.address'))
            ->columns(\Sharenjoy\NoahCms\Utils\Table::make(Address::class))
            ->filters(\Sharenjoy\NoahCms\Utils\Filter::make(Address::class, User::class))
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                // Tables\Actions\AttachAction::make()->preloadRecordSelect()->recordSelectSearchColumns(['title', 'description', 'slug'])->multiple(),
            ])
            ->actions([
                // Tables\Actions\DetachAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
