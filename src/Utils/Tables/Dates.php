<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;

class Dates extends TableAbstract implements TableInterface
{
    public function make()
    {
        return TextColumn::make('created_at')
            ->html()
            ->size(TextColumnSize::Small)
            ->sortable()
            ->formatStateUsing(function ($record) {
                return '<div><div class="pb-2">建立於 ' . $record->created_at->diffForHumans() . '<br>' . $record->created_at . '</div><div>上次更新 ' . $record->updated_at->diffForHumans() . '<br>' . $record->updated_at . '</div></div>';
            })
            ->label(__('noah-cms::noah-cms.dates'))
            ->toggleable(isToggledHiddenByDefault: $this->content['isToggledHiddenByDefault'] ?? false);
    }
}
