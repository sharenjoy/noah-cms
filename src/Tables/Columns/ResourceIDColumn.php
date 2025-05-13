<?php

namespace Sharenjoy\NoahCms\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class ResourceIDColumn extends TextColumn
{
    protected string $view = 'noah-cms::tables.columns.resource-id';

    protected array $content;

    public function content(array $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getContent(): array
    {
        return $this->content;
    }
}
