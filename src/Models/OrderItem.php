<?php

namespace Sharenjoy\NoahCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sharenjoy\NoahCms\Models\ProductSpecification;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class OrderItem extends Model
{
    use CommonModelTrait;
    use LogsActivity;

    protected $casts = [
        'preorder' => 'boolean',
        'quantity' => 'integer',
        'product_details' => 'json',
    ];

    protected array $sort = [
        'created_at' => 'asc',
    ];

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

    public function specification(): BelongsTo
    {
        return $this->belongsTo(ProductSpecification::class);
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(OrderShipment::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** OTHERS */
}
