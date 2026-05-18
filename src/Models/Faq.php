<?php

namespace Sharenjoy\NoahCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sharenjoy\NoahCms\Database\Factories\FaqFactory;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Sharenjoy\NoahCms\Models\Traits\HasCategoryTree;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class Faq extends Model implements Sortable
{
    use CommonModelTrait;
    use HasCategoryTree;
    use HasFactory;
    use HasTranslations;
    use LogsActivity;
    use SoftDeletes;
    use SortableTrait;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $translatable = [
        'question',
        'answer',
    ];

    protected array $sort = [
        'order_column' => 'asc',
    ];

    protected function formFields(): array
    {
        return [
            'left' => [
                'question' => [
                    'alias' => 'title',
                    'required' => true,
                    'rules' => ['required', 'string', 'max:255'],
                ],
                'answer' => [
                    'alias' => 'content',
                    'profile' => 'simple',
                    'required' => true,
                    'rules' => ['required'],
                ],
            ],
            'right' => [
                'is_active' => ['required' => true],
                'categories' => ['required' => true],
            ],
        ];
    }

    protected function tableFields(): array
    {
        return [
            'question' => ['label' => 'question'],
            'categories' => [],
            'is_active' => [],
            'created_at' => ['isToggledHiddenByDefault' => true],
            'updated_at' => ['isToggledHiddenByDefault' => true],
        ];
    }

    /** RELACTIONS */

    /** SCOPES */

    /** EVENTS */

    /** OTHERS */
    protected static function newFactory()
    {
        return FaqFactory::new();
    }
}
