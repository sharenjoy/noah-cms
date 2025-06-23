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

            if (! is_array($content)) {
                // 可以直接使用 Filamane table column component
                $columns[] = $content;
                continue;
            }

            $class = str()->studly((isset($content['alias']) ? $content['alias'] : $name));
            $column = null;

            if (class_exists('\\App\\Filament\\Utils\\Tables\\' . $class)) {
                // custom class
                $column = new ("\\App\\Filament\\Utils\\Tables\\$class")(fieldName: $name, content: $content)->make();
            } elseif (class_exists('\\Sharenjoy\\NoahCms\\Utils\\Tables\\' . $class)) {
                // class
                $column = new ("\\Sharenjoy\\NoahCms\\Utils\\Tables\\$class")(fieldName: $name, content: $content)->make();
            } elseif (class_exists('\\Sharenjoy\\NoahShop\\Utils\\Tables\\' . $class)) {
                // class
                $column = new ("\\Sharenjoy\\NoahShop\\Utils\\Tables\\$class")(fieldName: $name, content: $content)->make();
            } else {
                // others
                if ($name == 'title') {
                    $field = TextColumn::make('title')->label(__('noah-cms::noah-cms.title'))->limit(40)->searchable();
                    if ($content['description'] ?? false) {
                        $field = $field->description(fn(Model $record): string => str($record->description)->limit(50))->searchable(['title', 'description']);
                    }
                    $column = $field->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
                } elseif ($name == 'thumbnail') {
                    $column = MediaColumn::make($name)->label(__('noah-cms::noah-cms.image'))->square()->size($content['size'] ?? 40)->alignCenter()->defaultImageUrl(asset('vendor/noah-cms/images/placeholder.svg'))->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
                } elseif ($name == 'slug') {
                    $column = TextColumn::make($name)->label('Slug')->searchable()->limit(10)->tooltip(fn(Model $record): string => "By {$record->slug}")->copyable()->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
                } elseif ($name == 'categories') {
                    $column = TextColumn::make('categories.title')->label(__('noah-cms::noah-cms.categories'))->badge()->placeholder('-')->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
                } elseif ($name == 'tags') {
                    $column = SpatieTagsColumn::make($name)->label(__('noah-cms::noah-cms.tag'))->type($content['tagType'])->badge()->placeholder('-')->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
                } elseif ($name == 'roles') {
                    $column = TextColumn::make('roles.name')->label(__('noah-cms::noah-cms.role'))->badge()->placeholder('-')->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
                } elseif ($name == 'seo') {
                    if (! config('noah-cms.feature.seo')) {
                        continue;
                    }

                    $column = IconColumn::make($name)->label(__('noah-cms::noah-cms.seo'))->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false)
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
                    $column = IconColumn::make($name)->label(__('noah-cms::noah-cms.is_active'))->boolean()->sortable()->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
                } elseif ($name == 'published_at') {
                    $column = TextColumn::make($name)->label(__('noah-cms::noah-cms.published_at'))->since()->dateTimeTooltip('Y-m-d H:i:s')->sortable()->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
                } elseif ($name == 'created_at') {
                    $column = TextColumn::make($name)->label(__('noah-cms::noah-cms.created_at'))->since()->dateTimeTooltip('Y-m-d H:i:s')->sortable()->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
                } elseif ($name == 'updated_at') {
                    $column = TextColumn::make($name)->label(__('noah-cms::noah-cms.updated_at'))->since()->dateTimeTooltip('Y-m-d H:i:s')->sortable()->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
                } else {
                    if (($content['type'] ?? []) == 'number') {
                        $summarize = [];
                        if (isset($content['summarize']) && in_array('sum', $content['summarize'])) {
                            $summarize[] = \Filament\Tables\Columns\Summarizers\Sum::make();
                        }
                        if (isset($content['summarize']) && in_array('avg', $content['summarize'])) {
                            $summarize[] = \Filament\Tables\Columns\Summarizers\Average::make();
                        }
                        $item = TextColumn::make($name)->numeric()->searchable()->sortable()->summarize($summarize);
                    } elseif (($content['type'] ?? []) == 'boolean') {
                        $item = IconColumn::make($name)->boolean()->sortable();
                    } elseif (($content['type'] ?? []) == 'date') {
                        $item = TextColumn::make($name)->since()->dateTimeTooltip('Y-m-d H:i:s')->sortable();
                    } else {
                        $item = TextColumn::make($name)->searchable()->placeholder('-')->sortable();
                    }

                    $column = $item->label(self::getLabel($name, $content))->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
                }
            }

            if (isset($content['suffix'])) {
                $column = $column->suffix($content['suffix']);
            }

            $columns[] = $column->wrapHeader();
        }

        return $columns;
    }

    protected static function getLabel($name, $content): string
    {
        if (isset($content['label'])) {
            if (! str_contains(__('noah-cms::noah-cms.' . $content['label']), 'noah-cms')) {
                return __('noah-cms::noah-cms.' . $content['label']);
            }

            if (! str_contains(__('noah-shop::noah-shop.' . $content['label']), 'noah-shop')) {
                return __('noah-shop::noah-shop.' . $content['label']);
            }
        }

        return __('noah-cms::noah-cms.' . $name);
    }
}
