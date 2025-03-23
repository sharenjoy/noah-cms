<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use RalphJSmit\Filament\MediaLibrary\Forms\Components\MediaPicker;

class Img extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = MediaPicker::make($this->fieldName)->label(__('Choose image'))->showFileName();

        $this->resolve();

        return $this->field;
    }
}
