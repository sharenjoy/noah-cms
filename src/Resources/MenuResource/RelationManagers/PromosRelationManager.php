<?php

namespace Sharenjoy\NoahCms\Resources\MenuResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Sharenjoy\NoahCms\Models\Menu;
use Sharenjoy\NoahCms\Models\Promo;
use Sharenjoy\NoahCms\Resources\Traits\CanViewShop;

class PromosRelationManager extends RelationManager
{
    use CanViewShop;

    protected static string $relationship = 'promos';

    protected static ?string $icon = 'heroicon-o-gift';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('noah-cms::noah-cms.promo');
    }

    protected static function getRecordLabel(): ?string
    {
        return __('noah-cms::noah-cms.promo');
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->promos->count();
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema(\Sharenjoy\NoahCms\Utils\Form::make(Promo::class, $form->getOperation()));
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn(Promo $record): string => "({$record->id}) {$record->title}")
            ->heading(__('noah-cms::noah-cms.promo'))
            ->columns(\Sharenjoy\NoahCms\Utils\Table::make(Promo::class))
            ->filters(\Sharenjoy\NoahCms\Utils\Filter::make(Promo::class, Menu::class))
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
