<?php

namespace Sharenjoy\NoahCms\Models;

use Sharenjoy\NoahCms\Utils\JsonLD;
use Sharenjoy\NoahCms\Utils\Media;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Sharenjoy\NoahCms\Models\Traits\HasCategoryTree;
use Sharenjoy\NoahCms\Models\Traits\HasMediaLibrary;
use Sharenjoy\NoahCms\Models\Traits\HasTags;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class Post extends Model implements Sortable
{
    use CommonModelTrait;
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use SortableTrait;
    use HasTranslations;
    use HasMediaLibrary;
    use HasTags;
    use HasCategoryTree;
    use HasSEO;

    protected $casts = [
        'album' => 'array',
        'categories' => 'array',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public $translatable = [
        'title',
        'description',
        'content',
    ];

    protected array $sort = [
        'published_at' => 'desc',
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
            'categories' => ['required' => true],
            'tags' => ['min' => 2, 'max' => 5, 'multiple' => true],
        ],
    ];

    protected array $tableFields = [
        'title' => [
            'description' => true,
        ],
        'slug' => [],
        'categories' => [],
        'tags' => [
            'tagType' => 'post',
        ],
        'thumbnail' => [],
        'seo' => [],
        'is_active' => [],
        'published_at' => [],
        'created_at' => ['isToggledHiddenByDefault' => true],
        'updated_at' => ['isToggledHiddenByDefault' => true],
    ];

    /** RELACTIONS */

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), $this->getTaggableMorphName(), $this->getTaggableTableName())
            ->using($this->getPivotModelClassName())
            ->where('type', 'post')
            ->ordered();
    }

    /** SCOPES */

    /** EVENTS */

    /** SEO */

    public function getDynamicSEOData(): SEOData
    {
        // TODO
        $path = route('news.detail', ['post' => $this], false);

        return new SEOData(
            title: $this->seo->getTranslation('title', app()->currentLocale()) ?: $this->title,
            description: $this->seo->description ?: $this->description,
            author: $this->seo->author ?: config('app.name'),
            image: $this->seo->image ? Media::imgUrl($this->seo->image) : Media::imgUrl($this->img),
            enableTitleSuffix: false,
            alternates: $this->getAlternateTag($path),
            schema: SchemaCollection::make()->add(fn(SEOData $SEOData) => JsonLD::article($SEOData, $this)),
        );
    }

    /** OTHERS */

    public function getReplicateAction($type)
    {
        $resourceName = 'posts';
        $classname = $type == 'table' ? '\Filament\Tables\Actions\ReplicateAction' : '\Filament\Actions\ReplicateAction';
        return $classname::make()
            ->after(function (Model $replica): void {
                $replica->slug = $replica->slug . '-' . $replica->id;
                $replica->is_active = false;
                $replica->save();
            })
            ->successRedirectUrl(function (Model $replica) use ($resourceName): string {
                $currentPanelId = Filament::getCurrentPanel()->getId();
                return route('filament.' . $currentPanelId . '.resources.' . $resourceName . '.edit', [
                    'record' => $replica,
                ]);
            });
    }
}
