<?php

namespace Sharenjoy\NoahCms\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Sharenjoy\NoahCms\Models\Product;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Sharenjoy\NoahCms\Models\Traits\HasMediaLibrary;
use Sharenjoy\NoahCms\Utils\Media;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class Brand extends Model implements Sortable
{
    use CommonModelTrait;
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use SortableTrait;
    use HasTranslations;
    use HasMediaLibrary;
    use HasSEO;

    protected $casts = [
        'album' => 'array',
        'is_active' => 'boolean',
    ];

    public $translatable = [
        'title',
        'description',
        'content',
    ];

    protected array $sort = [
        'order_column' => 'asc',
    ];

    protected function formFields(): array
    {
        return [
            'left' => [
                'title' => [
                    'slug' => true,
                    'required' => true,
                    'rules' => ['required', 'string'],
                ],
                'slug' => ['maxLength' => 50, 'required' => true],
                'description' => ['required' => true, 'rules' => ['required', 'string']],
                'content' => ['profile' => 'simple'],
            ],
            'right' => [
                'img' => ['required' => true],
                'album' => [],
                'is_active' => ['required' => true],
            ],
        ];
    }

    protected function tableFields(): array
    {
        return [
            'title' => ['description' => true],
            'slug' => [],
            'relationCount' => ['label' => 'products_count', 'relation' => 'products'],
            'thumbnail' => [],
            'seo' => [],
            'is_active' => [],
            'created_at' => ['isToggledHiddenByDefault' => true],
            'updated_at' => ['isToggledHiddenByDefault' => true],
        ];
    }

    /** RELACTIONS */

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** SEO */

    public function getDynamicSEOData(): SEOData
    {
        // TODO
        $path = route('brands.detail', ['brand' => $this], false);

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
        return \Sharenjoy\NoahCms\Database\Factories\BrandFactory::new();
    }

    public function getReplicateAction($type)
    {
        $resourceName = 'brands';
        $classname = $type == 'table' ? '\Filament\Tables\Actions\ReplicateAction' : '\Filament\Actions\ReplicateAction';
        return $classname::make()
            ->after(function (Model $replica): void {
                $replica->slug = $replica->slug . '-' . $replica->id;
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
