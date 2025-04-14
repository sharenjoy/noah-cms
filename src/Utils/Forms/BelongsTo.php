<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;

class BelongsTo extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = Select::make($this->fieldName)
            ->label(__('noah-cms::noah-cms.' . $this->content['relation']))
            ->prefixIcon('heroicon-o-lifebuoy')
            ->relationship(
                name: $this->content['relation'],
                titleAttribute: $this->content['title'] ?? 'title',
                modifyQueryUsing: fn(Builder $query) => $query->withTrashed()->sort(),
            )
            ->createOptionForm(\Sharenjoy\NoahCms\Utils\Form::make('\\Sharenjoy\\NoahCms\Models\\' . ucfirst($this->content['relation']), 'create'))
            ->searchable()
            ->required()
            ->preload();

        $this->resolve();

        return $this->field;
    }
}
