<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\TextInput;

class Title extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = TextInput::make($this->fieldName)->placeholder(__('John Doe'))->translateLabel();

        $this->resolve();

        return $this->field;
    }
}
