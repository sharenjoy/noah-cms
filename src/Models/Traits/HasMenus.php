<?php

namespace Sharenjoy\NoahCms\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Sharenjoy\NoahCms\Models\Menu;

trait HasMenus
{
    public function menus(): MorphToMany
    {
        return $this->morphToMany(Menu::class, 'menuable');
    }
}
