<?php

namespace Sharenjoy\NoahCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Sharenjoy\NoahCms\Models\Menu;
use Sharenjoy\NoahCms\Models\Post;
use Sharenjoy\NoahCms\Models\Product;
use Sharenjoy\NoahCms\Models\Promo;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Sharenjoy\NoahCms\Models\Traits\HasMediaLibrary;
use Sharenjoy\NoahCms\Models\Traits\HasMenuTree;
use Sharenjoy\NoahCms\Utils\Media;
use SolutionForest\FilamentTree\Concern\ModelTree;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use CommonModelTrait;
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use HasTranslations;
    use HasMediaLibrary;
    use ModelTree;
    use HasMenuTree;
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
        'thumbnail' => [],
        'title' => ['description' => true],
        'slug' => [],
        'relation_count' => ['label' => 'products_count', 'relation' => 'products'],
        'post_relation_count' => ['alias' => 'relation_count', 'label' => 'posts_count', 'relation' => 'posts'],
        'menu_relation_count' => ['alias' => 'relation_count', 'label' => 'menus_count', 'relation' => 'menus'],
        'seo' => [],
        'is_active' => [],
        'created_at' => [],
        'updated_at' => [],
    ];

    /** RELACTIONS */

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'categorizable');
    }

    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'categorizable');
    }

    public function menus(): MorphToMany
    {
        return $this->morphedByMany(Menu::class, 'categorizable');
    }

    /** SCOPES */

    /** EVENTS */

    /** SEO */

    public function getDynamicSEOData(): SEOData
    {
        // TODO
        $path = route('category.detail', ['category' => $this], false);

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

    protected static function newFactory()
    {
        return \Sharenjoy\NoahCms\Database\Factories\CategoryFactory::new();
    }
}
