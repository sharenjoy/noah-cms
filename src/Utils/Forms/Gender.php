<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\Radio;

class Gender extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = Radio::make($this->fieldName)
            ->label(__('noah-cms::noah-cms.' . $this->fieldName))
            ->options($this->content['options'] ?? [
                'male' => __('noah-cms::noah-cms.male'),
                'female' => __('noah-cms::noah-cms.female'),
                'other' => __('noah-cms::noah-cms.other'),
            ])
            ->default($this->content['default'] ?? false)
            ->inline()
            ->inlineLabel(false);

        $this->resolve();

        return $this->field;
    }
}
