<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;

class BelongsTo extends FormAbstract implements FormInterface
{
    public function make()
    {
        $relationModel = null;
        if (class_exists('\\Sharenjoy\\NoahCms\\Models\\' . ucfirst($this->content['relation']))) {
            $relationModel = '\\Sharenjoy\\NoahCms\\Models\\' . ucfirst($this->content['relation']);
        } elseif (class_exists('\\Sharenjoy\\NoahShop\\Models\\' . ucfirst($this->content['relation']))) {
            $relationModel = '\\Sharenjoy\\NoahShop\\Models\\' . ucfirst($this->content['relation']);
        } else {
            throw new \Exception('Model ' . $this->content['relation'] . ' not found.');
        }

        $this->field = Select::make($this->fieldName)
            ->label(__('noah-cms::noah-cms.' . $this->content['relation']))
            ->prefixIcon('heroicon-o-arrows-right-left')
            ->relationship(
                name: $this->content['relation'],
                titleAttribute: $this->content['title'] ?? 'title',
                modifyQueryUsing: fn(Builder $query) => $query->withTrashed()->sort(),
            )
            ->createOptionForm(\Sharenjoy\NoahCms\Utils\Form::make($relationModel, 'create'))
            ->searchable()
            ->required()
            ->preload();

        $this->resolve();

        return $this->field;
    }
}
