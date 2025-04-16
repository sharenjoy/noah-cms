<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;

class Status extends TableAbstract implements TableInterface
{
    public function make()
    {
        return TextColumn::make($this->fieldName)
            ->badge('\\Sharenjoy\\NoahCms\\Enums\\' . ucfirst($this->content['model']) . 'Status')
            ->label(__('noah-cms::noah-cms.' . ($this->content['label'] ?? $this->fieldName)))
            ->toggleable(isToggledHiddenByDefault: $this->content['isToggledHiddenByDefault'] ?? false);
    }
}
