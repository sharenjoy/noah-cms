<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\TextInput;

class UserEmail extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = TextInput::make($this->fieldName)
            ->label(__('noah-cms::noah-cms.' . $this->fieldName))
            ->placeholder('name@example.com')
            ->disabled(fn($record) => $record !== null ? true : false);

        $this->resolve();

        return $this->field;
    }
}
