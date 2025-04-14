<?php

namespace Sharenjoy\NoahCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahCms\Models\Invoice;
use Sharenjoy\NoahCms\Models\Promo;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Sharenjoy\NoahCms\Models\Traits\HasCategoryTree;
use Sharenjoy\NoahCms\Models\Traits\HasMediaLibrary;
use Sharenjoy\NoahCms\Models\Traits\HasTags;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class InvoicePrice extends Model
{
    use CommonModelTrait;
    use LogsActivity;

    protected $casts = [];

    protected array $sort = [
        'created_at' => 'desc',
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

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** OTHERS */
}
