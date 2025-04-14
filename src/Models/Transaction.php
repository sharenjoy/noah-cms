<?php

namespace Sharenjoy\NoahCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahCms\Actions\ChargeExpireDateSetting;
use Sharenjoy\NoahCms\Actions\GenerateSeriesNumber;
use Sharenjoy\NoahCms\Enums\PaymentMethod;
use Sharenjoy\NoahCms\Models\Invoice;
use Sharenjoy\NoahCms\Models\Order;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends Model
{
    use CommonModelTrait;
    use LogsActivity;

    protected $casts = [
        'expired_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    protected array $sort = [
        'created_at' => 'desc',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->sn) {
                $model->sn = GenerateSeriesNumber::run(model: 'transaction', prefix: 'T', strLeng: 4);
            }

            if ($model->payment_method == PaymentMethod::ATM->value) {
                $model = ChargeExpireDateSetting::run(transaction: $model);
            }
        });
    }

    protected function formFields(): array
    {
        return [
            'left' => [
                'title' => [
                    'slug' => true,
                    'required' => true,
                    'rules' => ['required', 'string'],
                    // 'localeRules' => [
                    //     'zh_TW' => ['required', 'string', 'max:255'],
                    //     'en' => ['required', 'string', 'max:255'],
                    // ],
                ],
                'slug' => ['maxLength' => 50, 'required' => true],
                'categories' => ['required' => true],
                'tags' => ['min' => 2, 'max' => 5, 'multiple' => true],
                'description' => ['required' => true, 'rules' => ['required', 'string']],
                'content' => [
                    'profile' => 'simple',
                    'required' => true,
                    'rules' => ['required'],
                ],
            ],
            'right' => [
                'img' => ['required' => true],
                'album' => ['required' => true],
                'is_active' => ['required' => true],
                'published_at' => ['required' => true],
            ],
        ];
    }

    protected function tableFields(): array
    {
        return [
            'title' => ['description' => true],
            'slug' => [],
            'categories' => [],
            'tags' => ['tagType' => 'product'],
            'thumbnail' => [],
            'seo' => [],
            'is_active' => [],
            'published_at' => [],
            'created_at' => ['isToggledHiddenByDefault' => true],
            'updated_at' => ['isToggledHiddenByDefault' => true],
        ];
    }

    /** RELACTIONS */

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** OTHERS */
}
