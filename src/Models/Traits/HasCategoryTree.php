<?php

namespace Sharenjoy\NoahCms\Models\Traits;

use Sharenjoy\NoahCms\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasCategoryTree
{
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
