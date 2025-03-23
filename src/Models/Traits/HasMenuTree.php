<?php

namespace Sharenjoy\NoahCms\Models\Traits;

use Sharenjoy\NoahCms\Models\Menu;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasMenuTree
{
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class);
    }
}
