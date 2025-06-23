<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Filament\Tables\Columns\TextColumn;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;

class Status extends TableAbstract implements TableInterface
{
    public function make()
    {
        $enumModel = null;
        $subfix = ucfirst($this->content['model']) . ucfirst($this->content['cate'] ?? 'Status');

        if (class_exists('\\Sharenjoy\\NoahCms\\Enums\\' . $subfix)) {
            $enumModel = '\\Sharenjoy\\NoahCms\\Enums\\' . $subfix;
        } elseif (class_exists('\\Sharenjoy\\NoahShop\\Enums\\' . $subfix)) {
            $enumModel = '\\Sharenjoy\\NoahShop\\Enums\\' . $subfix;
        } else {
            throw new \Exception('Enum ' . $subfix . ' not found.');
        }

        return TextColumn::make($this->fieldName)
            ->html()
            ->formatStateUsing(function ($state) {
                return '<span class="inline-flex items-center px-1 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">' . $state->getLabel() . '</span>';
            })
            ->sortable()
            ->badge($enumModel)
            ->label($this->getLabel($this->fieldName, $this->content))
            ->toggleable(isToggledHiddenByDefault: $this->content['isToggledHiddenByDefault'] ?? false);
    }
}
