<?php

namespace Sharenjoy\NoahCms\Models;

use Filament\Facades\Filament;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Sharenjoy\NoahCms\Actions\ResolveProductSpecsDataToRecords;
use Sharenjoy\NoahCms\Models\ProductSpecification;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Sharenjoy\NoahCms\Models\Traits\HasCategoryTree;
use Sharenjoy\NoahCms\Models\Traits\HasMediaLibrary;
use Sharenjoy\NoahCms\Models\Traits\HasTags;
use Sharenjoy\NoahCms\Utils\JsonLD;
use Sharenjoy\NoahCms\Utils\Media;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements Sortable
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
        'is_single_spec' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
        'specs' => 'json',
    ];

    public $translatable = [
        'title',
        'description',
        'content',
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
        'relationCount' => ['label' => 'product_specifications_count', 'relation' => 'productSpecifications'],
        'thumbnail' => [],
        'seo' => [],
        'is_active' => [],
        'published_at' => [],
        'created_at' => ['isToggledHiddenByDefault' => true],
        'updated_at' => ['isToggledHiddenByDefault' => true],
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
                'description' => ['required' => true, 'rules' => ['required', 'string']],
                'is_single_spec' => ['alias' => 'yes_no', 'required' => true, 'disable' => 'edit', 'live' => true],
                'specs' => Section::make()->schema([
                    Repeater::make('specs')
                        ->label(__('noah-cms::noah-cms.specification'))
                        ->schema([
                            TextInput::make('spec_name')->label(__('noah-cms::noah-cms.spec_name'))->required(),
                            Repeater::make('spec_details')
                                ->label(__('noah-cms::noah-cms.spec_details'))
                                ->schema([
                                    TextInput::make('detail_name')->label(__('noah-cms::noah-cms.spec_detail_name'))->required(),
                                ])
                                ->columns(1)
                        ])
                        ->disabled(function (string $operation) {
                            return $operation === 'edit' ? true : false;
                        })
                        ->columns(1)
                        ->collapsible()
                        ->maxItems(3)
                        ->visible(fn(Get $get): bool => $get('is_single_spec') == false)
                ]),
                'content' => [
                    'profile' => 'simple',
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
    }

    /** RELACTIONS */

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), $this->getTaggableMorphName(), $this->getTaggableTableName())
            ->using($this->getPivotModelClassName())
            ->where('type', 'product')
            ->ordered();
    }

    public function productSpecifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** SEO */

    public function getDynamicSEOData(): SEOData
    {
        // TODO
        $path = route('products.detail', ['post' => $this], false);

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
        $resourceName = 'products';
        $classname = $type == 'table' ? '\Filament\Tables\Actions\ReplicateAction' : '\Filament\Actions\ReplicateAction';
        return $classname::make()
            ->after(function (Model $replica): void {
                $replica->slug = $replica->slug . '-' . $replica->id;
                $replica->is_active = false;
                $replica->save();

                // 複製規格
                ResolveProductSpecsDataToRecords::run($replica->specs, $replica, 'create');
            })
            ->successRedirectUrl(function (Model $replica) use ($resourceName): string {
                $currentPanelId = Filament::getCurrentPanel()->getId();
                return route('filament.' . $currentPanelId . '.resources.' . $resourceName . '.edit', [
                    'record' => $replica,
                ]);
            });
    }
}
