<?php

namespace Sharenjoy\NoahCms\Models\Traits;

use Sharenjoy\NoahCms\Models\CoinMutation;

trait HasCoinMutations
{
    /**
     * Relation with CoinMutation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function CoinMutations()
    {
        return $this->morphMany(CoinMutation::class, 'reference');
    }
}
