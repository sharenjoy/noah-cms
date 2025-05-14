<?php

namespace Sharenjoy\NoahCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Sharenjoy\NoahCms\Models\Traits\HasMediaLibrary;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class Carousel extends Model implements Sortable
{
    use CommonModelTrait;
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use SortableTrait;
    use HasTranslations;
    use HasMediaLibrary;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $translatable = [
        'title',
        'description',
    ];

    protected array $sort = [
        'order_column' => 'asc',
    ];

    protected function formFields(): array
    {
        return [
            'left' => [
                'title' => [
                    'required' => true,
                    'rules' => ['required', 'string'],
                ],
                'description' => ['rules' => ['string']],
            ],
            'right' => [
                'img' => ['required' => true],
                'is_active' => ['required' => true],
            ],
        ];
    }

    protected function tableFields(): array
    {
        return [
            'thumbnail' => [],
            'title' => ['description' => true],
            'is_active' => [],
            'created_at' => [],
            'updated_at' => [],
        ];
    }

    /** RELACTIONS */

    /** SCOPES */

    /** EVENTS */

    /** SEO */

    /** OTHERS */

    protected static function newFactory()
    {
        return \Sharenjoy\NoahCms\Database\Factories\CarouselFactory::new();
    }
}
