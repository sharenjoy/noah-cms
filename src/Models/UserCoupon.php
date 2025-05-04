<?php

namespace Sharenjoy\NoahCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahCms\Models\Promo;
use Sharenjoy\NoahCms\Models\User;

class UserCoupon extends Model
{
    protected $casts = [
        'used_at' => 'datetime',
        'started_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
