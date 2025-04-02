<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\TextInput;

class Price extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = TextInput::make($this->fieldName)->placeholder(__('noah-cms::noah-cms.price'))->label(__('noah-cms::noah-cms.' . $this->fieldName));

        $this->resolve();

        return $this->field;
    }
}
