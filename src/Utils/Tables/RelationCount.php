<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Filament\Tables\Columns\TextColumn;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;

class RelationCount extends TableAbstract implements TableInterface
{
    public function make()
    {
        return TextColumn::make($this->content['label'])
            ->counts($this->content['relation'])
            ->numeric()
            ->sortable()
            ->label($this->getLabel($this->fieldName, $this->content))
            ->toggleable(isToggledHiddenByDefault: $this->content['isToggledHiddenByDefault'] ?? false);
    }
}
