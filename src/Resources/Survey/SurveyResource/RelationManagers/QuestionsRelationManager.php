<?php

namespace Sharenjoy\NoahCms\Resources\Survey\SurveyResource\RelationManagers;

use Filament\Forms\Components\Section as FormSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentModalRelationManagers\Actions\Table\RelationManagerAction;
use Illuminate\Database\Eloquent\Model;
use Sharenjoy\NoahCms\Models\Survey\Question;
use Sharenjoy\NoahCms\Models\Survey\Section;
use Sharenjoy\NoahCms\Resources\Survey\SurveyResource\RelationManagers\AnswersRelationManager;
use Sharenjoy\NoahCms\Resources\Traits\NoahBaseRelationManager;

class QuestionsRelationManager extends RelationManager
{
    use NoahBaseRelationManager;

    protected static string $relationship = 'questions';

    protected static ?string $icon = 'heroicon-o-question-mark-circle';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('noah-cms::noah-cms.survey.navigation.question.label');
    }

    protected static function getRecordLabel(): ?string
    {
        return __('noah-cms::noah-cms.survey.navigation.question.label');
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->questions->count();
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema(array_merge([
                FormSection::make()->schema([
                    Select::make('section_id')
                        ->label(__('noah-cms::noah-cms.survey.title.section'))
                        ->helperText(__('noah-cms::noah-cms.survey.help.section'))
                        ->options(fn() => Section::where('survey_id', $this->getOwnerRecord()->id)->pluck('title', 'id'))
                        ->required(),
                ]),
            ], \Sharenjoy\NoahCms\Utils\Form::make(Question::class, $form->getOperation())));
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn(Question $record): string => "({$record->id}) {$record->title}")
            ->heading(__('noah-cms::noah-cms.survey.navigation.question.label'))
            ->columns(\Sharenjoy\NoahCms\Utils\Table::make(Question::class))
            ->filters(\Sharenjoy\NoahCms\Utils\Filter::make(Question::class))
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                // Tables\Actions\AttachAction::make()->preloadRecordSelect()->recordSelectSearchColumns(['title', 'description', 'slug'])->multiple(),
            ])
            ->actions([
                // Tables\Actions\DetachAction::make(),
                RelationManagerAction::make('answers-relation-manager')
                    ->label('檢視答案')
                    ->icon('heroicon-o-arrow-right')
                    ->relationManager(AnswersRelationManager::make()),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->reorderable('order_column')
            ->defaultSort('order_column');
    }
}
