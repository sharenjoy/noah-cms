<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use CodeWithDennis\FilamentSelectTree\SelectTree;

class Categories extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = SelectTree::make('categories')
            ->label(__('noah-cms::noah-cms.categories'))
            ->placeholder(__('noah-cms::noah-cms.please_select_category'))
            ->emptyLabel(__('noah-cms::noah-cms.no_results_found'))
            ->prefixIcon('heroicon-o-circle-stack')
            ->searchable()
            ->enableBranchNode()
            ->parentNullValue(-1)
            ->withCount()
            ->independent(true)
            ->expandSelected(true)
            ->grouped(false)
            ->withTrashed(false)
            ->defaultOpenLevel($this->content['defaultOpenLevel'] ?? 10)
            ->relationship(
                relationship: 'categories',
                titleAttribute: 'title',
                parentAttribute: 'parent_id',
                modifyQueryUsing: fn($query) => $query->orderBy('order'),
                modifyChildQueryUsing: fn($query) => $query->orderBy('order')
            );

        $this->resolve();

        return $this->field;
    }
}
