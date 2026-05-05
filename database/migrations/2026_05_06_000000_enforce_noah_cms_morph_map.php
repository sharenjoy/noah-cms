<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $morphMap = $this->morphMap();

        foreach ($this->morphTypeColumns() as $table => $columns) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            foreach ($columns as $column) {
                if (! Schema::hasColumn($table, $column)) {
                    continue;
                }

                foreach ($morphMap as $alias => $model) {
                    DB::table($table)
                        ->where($column, $model)
                        ->update([$column => $alias]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 資料表可能有多個 User 模型來源，還原 FQCN 會有歧義，故保留目前的 morph alias。
    }

    private function morphMap(): array
    {
        $models = [
            \Sharenjoy\NoahCms\Models\Carousel::class,
            \Sharenjoy\NoahCms\Models\Category::class,
            \Sharenjoy\NoahCms\Models\Menu::class,
            \Sharenjoy\NoahCms\Models\Permission::class,
            \Sharenjoy\NoahCms\Models\Post::class,
            \Sharenjoy\NoahCms\Models\Role::class,
            \Sharenjoy\NoahCms\Models\Seo::class,
            \Sharenjoy\NoahCms\Models\StaticPage::class,
            \Sharenjoy\NoahCms\Models\Tag::class,
            \Sharenjoy\NoahCms\Models\User::class,
            \Sharenjoy\NoahShop\Models\Product::class,
            \Sharenjoy\NoahShop\Models\Promo::class,
            \Sharenjoy\NoahShop\Models\Survey\Survey::class,
        ];

        $models = array_merge($models, array_values(config('noah-cms.models', [])));

        $morphMap = collect($models)
            ->filter(fn ($model): bool => is_string($model))
            ->mapWithKeys(fn (string $model): array => [class_basename($model) => $model])
            ->all();

        $configuredMorphMap = collect(config('noah-cms.morph_map', []))
            ->filter(fn ($model): bool => is_string($model))
            ->mapWithKeys(function (string $model, int|string $alias): array {
                $alias = is_string($alias) ? class_basename($alias) : class_basename($model);

                return [$alias => $model];
            })
            ->all();

        return array_merge($morphMap, $configuredMorphMap);
    }

    private function morphTypeColumns(): array
    {
        return [
            'activity_log' => ['subject_type', 'causer_type'],
            'categorizables' => ['categorizable_type'],
            'media' => ['model_type'],
            'menuables' => ['menuable_type'],
            'model_has_permissions' => ['model_type'],
            'model_has_roles' => ['model_type'],
            'nested_comments' => ['commentable_type', 'reactable_type'],
            'notifications' => ['notifiable_type'],
            'seo' => ['model_type'],
            'statuses' => ['model_type'],
            'taggables' => ['taggable_type'],
        ];
    }
};
