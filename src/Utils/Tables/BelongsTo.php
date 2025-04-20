<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Sharenjoy\NoahCms\Tables\Columns\BelongsToColumn;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;

class BelongsTo extends TableAbstract implements TableInterface
{
    public function make()
    {
        return BelongsToColumn::make($this->fieldName)
            ->content($this->content)
            ->width('1%')
            ->searchable()
            ->sortable()
            ->label(__('noah-cms::noah-cms.' . ($this->content['label'] ?? $this->fieldName)))
            ->toggleable(isToggledHiddenByDefault: false);
    }
}
