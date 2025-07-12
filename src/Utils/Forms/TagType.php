<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\Select;

class TagType extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = Select::make($this->fieldName)
            ->label(__('noah-cms::noah-cms.' . $this->fieldName))
            ->options(config('noah-cms.enums.TagType')::visibleOptions());

        $this->resolve();

        return $this->field;
    }
}
