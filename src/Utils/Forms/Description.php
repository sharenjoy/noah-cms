<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\Textarea;

class Description extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = Textarea::make($this->fieldName)->placeholder(__('noah-cms::noah-cms.here_is_description'))->label(__('noah-cms::noah-cms.' . $this->fieldName));

        $this->resolve();

        return $this->field;
    }
}
