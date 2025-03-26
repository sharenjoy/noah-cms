<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\TextInput;

class Slug extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = TextInput::make($this->fieldName)
            ->disabled(function (string $operation) {
                return $operation === 'create' ? true : false;
            })
            ->helperText(__('noah-cms::noah-cms.slug_help_text'))
            ->placeholder('good-day')
            ->prefixIcon('heroicon-m-globe-alt')
            ->dehydrated()
            ->maxLength($this->content['maxLength'] ?? 50)
            ->unique($this->model, 'slug', ignoreRecord: true);

        $this->resolve();

        return $this->field;
    }
}
