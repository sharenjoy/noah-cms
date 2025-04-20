<?php

namespace Sharenjoy\NoahCms\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class BelongsToColumn extends TextColumn
{
    protected string $view = 'noah-cms::tables.columns.belongs-to';

    protected array $content;

    public function content(array $content): static
    {
        $this->content = $content;

        if (isset($content['relation'])) {
            $string = $this->camelToKebabCase($content['relation']);
            $this->content['relation_route'] = str($string)->plural();

            if (!isset($this->content['relation_column'])) {
                $this->content['relation_column'] = str_replace('-', '_', $string) . '_id';
            }
        }

        return $this;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    protected function camelToKebabCase(string $input): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $input));
    }
}
