<?php

namespace Sharenjoy\NoahCms\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Sharenjoy\NoahCms\Models\Category;

trait HasCategoryTree
{
    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }
}
