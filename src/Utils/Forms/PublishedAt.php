<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\DateTimePicker;

class PublishedAt extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = DateTimePicker::make($this->fieldName)
            ->label(__('noah-cms::noah-cms.published_at'))
            ->placeholder('2020-03-18 09:48:00')
            ->prefixIcon('heroicon-o-clock')
            ->format('Y-m-d H:i:s')
            ->native(false);

        $this->resolve();

        return $this->field;
    }
}
