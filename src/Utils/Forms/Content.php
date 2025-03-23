<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use FilamentTiptapEditor\TiptapEditor;

class Content extends FormAbstract implements FormInterface
{
    public function make()
    {
        $this->field = TiptapEditor::make($this->fieldName)
            ->translateLabel()
            ->profile($this->content['profile'] ?? 'simple')
            ->maxContentWidth('5xl')
            ->extraInputAttributes(['style' => 'min-height: 24rem;']);

        $this->resolve();

        return $this->field;
    }
}
