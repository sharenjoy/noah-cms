<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Filament\Facades\Filament;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Illuminate\Support\Str;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;

class BelongsTo extends TableAbstract implements TableInterface
{
    public function make()
    {
        return TextColumn::make($this->fieldName)
            ->url(function ($record) {
                return route('filament.' . Filament::getCurrentPanel()->getId() . '.resources.' . Str::plural($this->content['relation']) . '.edit', [
                    'record' => $record->{$this->content['relation'] . '_id'},
                ]);
            })
            ->color('primary')
            ->size(TextColumnSize::Large)
            ->weight(FontWeight::Bold)
            ->searchable()
            ->label(__('noah-cms::noah-cms.' . ($this->content['label'] ?? $this->fieldName)))
            ->toggleable(isToggledHiddenByDefault: false);
    }
}
