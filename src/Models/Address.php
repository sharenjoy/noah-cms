<?php

namespace Sharenjoy\NoahCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Sharenjoy\NoahCms\Models\Order;
use Sharenjoy\NoahCms\Models\OrderShipment;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Address extends Model
{
    use CommonModelTrait;
    use HasFactory;
    use LogsActivity;

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public $translatable = [];

    protected array $sort = [
        'created_at' => 'desc',
    ];

    protected array $formFields = [
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
            'description' => [],
            'content' => [
                'profile' => 'simple',
            ],
        ],
        'right' => [
            'img' => [],
            'album' => [],
            'is_active' => ['required' => true],
        ],
    ];

    protected array $tableFields = [
        'title' => [
            'description' => true,
        ],
        'slug' => [],
        'relationCount' => ['label' => 'categories_count', 'relation' => 'categories'],
        'thumbnail' => [],
        'seo' => [],
        'is_active' => [],
        'created_at' => [],
        'updated_at' => [],
    ];

    /** RELACTIONS */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** SEO */

    /** OTHERS */

    protected static function newFactory()
    {
        return \Sharenjoy\NoahCms\Database\Factories\AddressFactory::new();
    }
}
