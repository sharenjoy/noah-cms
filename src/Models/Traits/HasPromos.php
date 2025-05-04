<?php

namespace Sharenjoy\NoahCms\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Sharenjoy\NoahCms\Models\Promo;

trait HasPromos
{
    public function promos(): MorphToMany
    {
        return $this->morphToMany(Promo::class, 'promoable');
    }
}
