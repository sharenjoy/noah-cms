<?php

namespace Sharenjoy\NoahCms\Resources\CategoryResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Sharenjoy\NoahCms\Models\Category;
use Sharenjoy\NoahCms\Models\Post;
use Sharenjoy\NoahCms\Resources\PostResource;
use Sharenjoy\NoahCms\Resources\Traits\NoahBaseRelationManager;

class PostsRelationManager extends RelationManager
{
    use NoahBaseRelationManager;

    protected static string $relationship = 'posts';

    protected static ?string $icon = 'heroicon-o-newspaper';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('noah-cms::noah-cms.post');
    }

    protected static function getRecordLabel(): ?string
    {
        return __('noah-cms::noah-cms.post');
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->posts->count();
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema(\Sharenjoy\NoahCms\Utils\Form::make(Post::class, $form->getOperation()));
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn(Post $record): string => "({$record->id}) {$record->title}")
            ->heading(__('noah-cms::noah-cms.post'))
            ->columns(array_merge(static::getTableStartColumns(PostResource::class), \Sharenjoy\NoahCms\Utils\Table::make(Post::class)))
            ->filters(\Sharenjoy\NoahCms\Utils\Filter::make(Post::class, Category::class))
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
