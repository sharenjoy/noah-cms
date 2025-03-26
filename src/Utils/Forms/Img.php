<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use RalphJSmit\Filament\MediaLibrary\Forms\Components\MediaPicker;

class Img extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = MediaPicker::make($this->fieldName)->label(__('noah-cms::noah-cms.choose_image'))->showFileName();

        $this->resolve();

        return $this->field;
    }
}
