<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Sharenjoy\NoahCms\Models\Carousel;
use Sharenjoy\NoahCms\Models\Category;
use Sharenjoy\NoahCms\Models\Menu;
use Sharenjoy\NoahCms\Models\Permission;
use Sharenjoy\NoahCms\Models\Post;
use Sharenjoy\NoahCms\Models\Role;
use Sharenjoy\NoahCms\Models\Seo;
use Sharenjoy\NoahCms\Models\StaticPage;
use Sharenjoy\NoahCms\Models\Tag;
use Sharenjoy\NoahCms\Models\User;
use Sharenjoy\NoahShop\Models\Product;
use Sharenjoy\NoahShop\Models\Promo;
use Sharenjoy\NoahShop\Models\Survey\Survey;

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
            Carousel::class,
            Category::class,
            Menu::class,
            Permission::class,
            Post::class,
            Role::class,
            Seo::class,
            StaticPage::class,
            Tag::class,
            User::class,
            Product::class,
            Promo::class,
            Survey::class,
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
