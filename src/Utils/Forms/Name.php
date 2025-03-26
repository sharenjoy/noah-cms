<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\TextInput;

class Name extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = TextInput::make($this->fieldName)->placeholder(__('noah-cms::noah-cms.john_doe'))->translateLabel();

        $this->resolve();

        return $this->field;
    }
}
