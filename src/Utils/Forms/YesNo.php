<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\Radio;

class YesNo extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = Radio::make($this->fieldName)
            ->label(__('noah-cms::noah-cms.' . $this->fieldName))
            ->options($this->content['options'] ?? [
                true => __('noah-cms::noah-cms.yes'),
                false => __('noah-cms::noah-cms.no'),
            ])
            ->default($this->content['default'] ?? false)
            ->inline()
            ->inlineLabel(false);

        $this->resolve();

        return $this->field;
    }
}
