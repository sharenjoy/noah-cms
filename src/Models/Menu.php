<?php

namespace Sharenjoy\NoahCms\Models;

use Sharenjoy\NoahCms\Utils\Media;
use Sharenjoy\NoahCms\Models\Category;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Sharenjoy\NoahCms\Models\Traits\HasMediaLibrary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use SolutionForest\FilamentTree\Concern\ModelTree;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Menu extends Model
{
    use CommonModelTrait;
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use HasTranslations;
    use HasMediaLibrary;
    use ModelTree;
    use HasSEO;

    protected $casts = [
        'parent_id' => 'int',
        'album' => 'array',
        'is_active' => 'boolean',
    ];

    public $translatable = [
        'title',
        'description',
        'content',
    ];

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

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** SEO */

    public function getDynamicSEOData(): SEOData
    {
        // TODO
        $path = route('menu.detail', ['menu' => $this], false);

        return new SEOData(
            title: $this->seo->getTranslation('title', app()->currentLocale()) ?: $this->title,
            description: $this->seo->description ?: $this->description,
            author: $this->seo->author ?: config('app.name'),
            image: $this->seo->image ? Media::imgUrl($this->seo->image) : Media::imgUrl($this->img),
            enableTitleSuffix: false,
            alternates: $this->getAlternateTag($path),
            // schema: SchemaCollection::make()->add(fn(SEOData $SEOData) => JsonLD::article($SEOData, $this)),
        );
    }

    /** OTHERS */
}
