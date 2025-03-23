<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\Radio;

class IsActive extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = Radio::make($this->fieldName)
            ->label(__('Is active'))
            ->options($this->content['options'] ?? [
                true => __('Open'),
                false => __('Close'),
            ])
            ->inline()
            ->inlineLabel(false);

        $this->resolve();

        return $this->field;
    }
}
