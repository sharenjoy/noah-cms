<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\TextInput;
use Sharenjoy\NoahCms\Models\User;

class UserEmail extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = TextInput::make($this->fieldName)
            ->label(__('noah-cms::noah-cms.' . $this->fieldName))
            ->placeholder('name@example.com')
            ->unique(User::class, 'email', ignoreRecord: true)
            ->disabled(fn($record) => $record !== null ? true : false);

        $this->resolve();

        return $this->field;
    }
}
