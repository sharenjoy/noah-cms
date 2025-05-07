<?php

namespace Sharenjoy\NoahCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahCms\Enums\UserCouponStatus;
use Sharenjoy\NoahCms\Models\Promo;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Sharenjoy\NoahCms\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;

class UserCoupon extends Model
{
    use CommonModelTrait;
    use LogsActivity;

    protected $casts = [
        'status' => UserCouponStatus::class,
        'forever' => 'boolean',
        'started_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    protected array $formFields = [];

    protected array $tableFields = [
        'promo.title' =>  ['description' => true, 'alias' => 'belongs_to', 'label' => 'promo', 'relation' => 'shop.coupon-promos', 'relation_route' => 'shop.coupon-promos', 'relation_column' => 'promo_id'],
        'user.name' =>  ['description' => true, 'alias' => 'belongs_to', 'label' => 'user', 'relation' => 'user'],
        'code' => ['label' => 'coupon_promo'],
        'status' => ['model' => 'UserCouponStatus'],
        'forever' => ['type' => 'boolean', 'label' => 'shop.promo.title.forever'],
        'started_at' => ['label' => 'shop.promo.title.started_at'],
        'expired_at' => ['label' => 'shop.promo.title.expired_at'],
        'created_at' => ['isToggledHiddenByDefault' => true],
        'updated_at' => ['isToggledHiddenByDefault' => true],
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
