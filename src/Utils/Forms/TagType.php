<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Sharenjoy\NoahCms\Enums\TagType as EnumTagType;
use Filament\Forms\Components\Select;

class TagType extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = Select::make($this->fieldName)
            ->translateLabel()
            ->options(EnumTagType::class);

        $this->resolve();

        return $this->field;
    }
}
