<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\Radio;

class IsActive extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = Radio::make($this->fieldName)
            ->label(__('noah-cms::noah-cms.is_active'))
            ->options($this->content['options'] ?? [
                true => __('noah-cms::noah-cms.open'),
                false => __('noah-cms::noah-cms.close'),
            ])
            ->inline()
            ->inlineLabel(false);

        $this->resolve();

        return $this->field;
    }
}
