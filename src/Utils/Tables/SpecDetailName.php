<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Filament\Tables\Actions\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;
use stdClass;

class SpecDetailName extends TableAbstract implements TableInterface
{
    public function make()
    {
        return TextColumn::make($this->fieldName)
            ->label(__('noah-cms::noah-cms.' . ($this->content['label'] ?? $this->fieldName)))
            ->searchable()
            ->toggleable(isToggledHiddenByDefault: $this->content['isToggledHiddenByDefault'] ?? false)
            ->formatStateUsing(function ($state) {
                if ($state == 'single_spec') {
                    return __('noah-cms::noah-cms.' . $state);
                }
                return $state;
            });
    }
}
