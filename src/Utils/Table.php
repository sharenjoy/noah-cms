<?php

namespace Sharenjoy\NoahCms\Utils;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Filament\MediaLibrary\Tables\Columns\MediaColumn;

class Table
{
    public static function make($model): array
    {
        $table = app($model)->getTableFields();
        $columns = [];

        foreach ($table as $name => $content) {
            if ($name == 'title') {
                $field = TextColumn::make('title')->label(__('noah-cms::noah-cms.title'))->searchable()->wrap();
                if ($content['description'] ?? false) {
                    $field = $field->description(fn(Model $record): string => str($record->description)->limit(150))->searchable(['title', 'description']);
                }
                $columns[] = $field->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
            } elseif ($name == 'thumbnail') {
                $columns[] = MediaColumn::make($name)->label(__('noah-cms::noah-cms.image'))->circular()->size($content['size'] ?? 40)->alignCenter()->defaultImageUrl(asset('vendor/noah-cms/images/placeholder.jpg'))->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
            } elseif ($name == 'slug') {
                $columns[] = TextColumn::make($name)->label('Slug')->searchable()->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
            } elseif ($name == 'categories') {
                $columns[] = TextColumn::make('categories.title')->label(__('noah-cms::noah-cms.categories'))->badge()->placeholder('-')->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
            } elseif ($name == 'tags') {
                $columns[] = SpatieTagsColumn::make($name)->label(__('noah-cms::noah-cms.tag'))->type($content['type'])->badge()->placeholder('-')->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
            } elseif ($name == 'roles') {
                $columns[] = TextColumn::make('roles.name')->label(__('noah-cms::noah-cms.role'))->badge()->placeholder('-')->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
            } elseif ($name == 'seo') {
                if (! config('noah-cms.featureToggle.seo')) {
                    continue;
                }

                $columns[] = IconColumn::make($name)->label(__('noah-cms::noah-cms.seo'))->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false)
                    ->size(IconColumn\IconColumnSize::Medium)
                    ->icon(fn(string $state): string => match ($state) {
                        'green' => 'heroicon-c-check',
                        'orange' => 'heroicon-c-minus',
                        'red' => 'heroicon-c-minus',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'red' => 'gray',
                        'orange' => 'warning',
                        'green' => 'success',
                    })
                    ->state(function ($record) {
                        $seo = $record->seo;
                        if ($seo->title && $seo->description) return 'green';
                        if ($seo->title || $seo->description) return 'orange';
                        return 'red';
                    });
            } elseif ($name == 'is_active') {
                $columns[] = IconColumn::make($name)->label(__('noah-cms::noah-cms.' . $name))->boolean()->sortable()->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
            } elseif ($name == 'published_at') {
                $columns[] = TextColumn::make($name)->label(__('noah-cms::noah-cms.' . $name))->since()->dateTimeTooltip('Y-m-d H:i:s')->sortable()->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
            } elseif ($name == 'created_at') {
                $columns[] = TextColumn::make($name)->label(__('noah-cms::noah-cms.' . $name))->since()->dateTimeTooltip('Y-m-d H:i:s')->sortable()->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
            } elseif ($name == 'updated_at') {
                $columns[] = TextColumn::make($name)->label(__('noah-cms::noah-cms.' . $name))->since()->dateTimeTooltip('Y-m-d H:i:s')->sortable()->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
            } else {
                $columns[] = TextColumn::make($name)->label(__('noah-cms::noah-cms.' . $name))->searchable()->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
            }
        }

        return $columns;
    }
}
