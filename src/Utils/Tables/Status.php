<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Filament\Tables\Columns\TextColumn;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;

class Status extends TableAbstract implements TableInterface
{
    public function make()
    {
        return TextColumn::make($this->fieldName)
            ->html()
            ->formatStateUsing(function ($state) {
                return '<span class="inline-flex items-center px-1 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">' . $state->getLabel() . '</span>';
            })
            ->sortable()
            ->badge('\\Sharenjoy\\NoahCms\\Enums\\' . ucfirst($this->content['model']) . 'Status')
            ->label(__('noah-cms::noah-cms.' . ($this->content['label'] ?? $this->fieldName)))
            ->toggleable(isToggledHiddenByDefault: $this->content['isToggledHiddenByDefault'] ?? false);
    }
}
