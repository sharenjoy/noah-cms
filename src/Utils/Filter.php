<?php

namespace Sharenjoy\NoahCms\Utils;

use Sharenjoy\NoahCms\Utils\Forms\Categories;
use Sharenjoy\NoahCms\Utils\Forms\Tags;
use Sharenjoy\NoahCms\Models\Category;
use Sharenjoy\NoahCms\Models\Tag;
use Sharenjoy\NoahCms\Models\Traits\HasCategoryTree;
use Sharenjoy\NoahCms\Models\Traits\HasTags;
use Filament\Tables\Filters\Filter as TableFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filter
{
    private static string $model;
    private static ?string $resourceModel;

    public static function make(string $model, ?string $resourceModel = null): array
    {
        static::$model = $model;
        static::$resourceModel = $resourceModel;

        $filters = [];

        if (in_array(HasCategoryTree::class, class_uses(static::getModel())) && !in_array(static::getResourceModel(), [Category::class])) {
            $filters[] = TableFilter::make('tree')
                ->form([
                    (new Categories('categories', [], [], static::getModel()))->make(),
                ])
                ->query(function (Builder $query, array $data) {
                    return $query->when($data['categories'], function ($query, $categories) {
                        return $query->whereHas('categories', fn($query) => $query->whereIn('categories.id', $categories));
                    });
                })
                ->indicateUsing(function (array $data): ?string {
                    if (! $data['categories']) return null;
                    return __('noah-cms::noah-cms.categories') . ': ' . implode(', ', Category::whereIn('id', $data['categories'])->get()->pluck('title')->toArray());
                });
        }

        if (in_array(HasTags::class, class_uses(static::getModel())) && !in_array(static::getResourceModel(), [Tag::class])) {
            $filters[] = TableFilter::make('tags')
                ->form([
                    (new Tags('tags', ['multiple' => true], [], static::getModel()))->make(),
                ])
                ->query(function (Builder $query, array $data) {
                    return $query->when($data['tags'], function ($query, $tags) {
                        return $query->whereHas('tags', function ($query) use ($tags) {
                            $query->whereIn('id', $tags);
                        });
                    });
                })
                ->indicateUsing(function (array $data): ?string {
                    if (! $data['tags']) return null;
                    return __('noah-cms::noah-cms.tag') . ': ' . implode(', ', Tag::whereIn('id', $data['tags'])->get()->pluck('name')->toArray());
                });
        }

        if (array_key_exists('is_active', app(static::getModel())->getCasts())) {
            $filters[] = SelectFilter::make('is_active')->label(__('noah-cms::noah-cms.is_active'))
                ->options([
                    true => __('noah-cms::noah-cms.open'),
                    false => __('noah-cms::noah-cms.close'),
                ]);
        }

        if (in_array(SoftDeletes::class, class_uses(static::getModel()))) {
            $filters[] = TrashedFilter::make();
        }

        return $filters;
    }

    public static function getModel()
    {
        return static::$model;
    }

    public static function getResourceModel()
    {
        return static::$resourceModel;
    }
}
