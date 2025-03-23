<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\TextInput;

class Password extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = TextInput::make($this->fieldName)
            ->password()
            ->placeholder('*******')
            ->translateLabel()
            ->disabled(fn($record) => $record !== null ? true : false);

        $this->resolve();

        return $this->field;
    }
}
