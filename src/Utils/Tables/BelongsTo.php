<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Sharenjoy\NoahCms\Tables\Columns\BelongsToColumn;

class BelongsTo extends TableAbstract implements TableInterface
{
    public function make()
    {
        return BelongsToColumn::make($this->fieldName)
            ->content($this->content)
            // ->width('1%')
            ->searchable()
            ->sortable()
            ->visible(fn () => $this->content['visible'] ?? true)
            ->label($this->getLabel($this->fieldName, $this->content))
            ->toggleable(isToggledHiddenByDefault: false);
    }
}
