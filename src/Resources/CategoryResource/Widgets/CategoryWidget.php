<?php

namespace Sharenjoy\NoahCms\Resources\CategoryResource\Widgets;

use Sharenjoy\NoahCms\Models\Category;
use Filament\Notifications\Notification;
use SolutionForest\FilamentTree\Actions\Action;
use SolutionForest\FilamentTree\Actions\ActionGroup;
use SolutionForest\FilamentTree\Actions\DeleteAction;
use SolutionForest\FilamentTree\Actions\EditAction;
use SolutionForest\FilamentTree\Actions\ViewAction;
use SolutionForest\FilamentTree\Widgets\Tree as BaseWidget;

class CategoryWidget extends BaseWidget
{
    protected static string $model = Category::class;

    protected ?string $treeTitle = 'CategoryWidget';

    protected bool $enableTreeTitle = true;

    public static function getMaxDepth(): int
    {
        static::$maxDepth = config('noah-cms.categoryTree.maxDepth');
        return static::$maxDepth;
    }

    public function getTreeTitle(): ?string
    {
        return __('Category Widget') . ' (' . static::$maxDepth . ' ' . __('Level') . ')';
    }

    protected function getFormSchema(): array
    {
        return \Sharenjoy\NoahCms\Utils\Form::make(static::getModel(), 'edit');
    }

    // INFOLIST, CAN DELETE
    public function getViewFormSchema(): array
    {
        return [
            //
        ];
    }

    // CUSTOMIZE ICON OF EACH RECORD, CAN DELETE
    // public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    // {
    //     return null;
    // }

    // CUSTOMIZE ACTION OF EACH RECORD, CAN DELETE
    // protected function getTreeActions(): array
    // {
    //     return [
    //         Action::make('helloWorld')
    //             ->action(function () {
    //                 Notification::make()->success()->title('Hello World')->send();
    //             }),
    //         // ViewAction::make(),
    //         // EditAction::make(),
    //         ActionGroup::make([
    //
    //             ViewAction::make(),
    //             EditAction::make(),
    //         ]),
    //         DeleteAction::make(),
    //     ];
    // }
    // OR OVERRIDE FOLLOWING METHODS
    //protected function hasDeleteAction(): bool
    //{
    //    return true;
    //}
    //protected function hasEditAction(): bool
    //{
    //    return true;
    //}
    protected function hasViewAction(): bool
    {
        return true;
    }
}
