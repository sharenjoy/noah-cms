<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\Select;

class Tags extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = Select::make($this->fieldName)
            ->label(__('Tag'))
            ->preload()
            ->prefixIcon('heroicon-c-tag')
            ->relationship(name: $this->fieldName, titleAttribute: 'name')
            ->searchable(['name', 'slug']);

        if ($this->content['multiple'] ?? false) {
            $this->field = $this->field->multiple()
                ->minItems($this->content['min'] ?? 0)
                ->maxItems($this->content['max'] ?? 99);
        }

        $this->resolve();

        return $this->field;
    }
}
