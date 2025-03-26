<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use RalphJSmit\Filament\MediaLibrary\Forms\Components\MediaPicker;

class Album extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = MediaPicker::make($this->fieldName)
            ->label(__('noah-cms::noah-cms.select_photo_album'))
            ->showFileName()
            ->multiple()
            ->reorderable();

        $this->resolve();

        return $this->field;
    }
}
