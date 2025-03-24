<?php

namespace Sharenjoy\NoahCms\Models;

use Sharenjoy\NoahCms\Utils\Media;
use Sharenjoy\NoahCms\Models\Post;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use ArrayAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as DbCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Overtrue\Pinyin\Pinyin;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class Tag extends Model implements Sortable
{
    use CommonModelTrait;
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use SortableTrait;
    use HasTranslations;
    use HasSEO;

    public array $translatable = [
        'name',
    ];

    protected array $formFields = [
        'left' => [
            'name' => [
                'slug' => true,
                'required' => true,
                'rules' => ['required', 'string'],
                // 'localeRules' => [
                //     'zh_TW' => ['required', 'string', 'max:255'],
                //     'en' => ['required', 'string', 'max:255'],
                // ],
            ],
            'slug' => ['maxLength' => 50, 'required' => true],
            'type' => ['alias' => 'tag_type', 'required' => true],
        ],
        'right' => [],
    ];

    protected array $tableFields = [
        'name' => [],
        'slug' => [],
        'type' => [],
        'seo' => [],
        'created_at' => [],
        'updated_at' => ['isToggledHiddenByDefault' => false],
    ];

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    /** SEO */

    public function getDynamicSEOData(): SEOData
    {
        // TODO
        $path = route('tag.detail', ['tag' => $this], false);

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

    public function scopeWithType(Builder $query, ?string $type = null): Builder
    {
        if (is_null($type)) {
            return $query;
        }

        return $query->where('type', $type)->ordered();
    }

    public function scopeContaining(Builder $query, string $name, $locale = null): Builder
    {
        $locale = $locale ?? static::getLocale();

        return $query->whereRaw('lower(' . $this->getQuery()->getGrammar()->wrap('name->' . $locale) . ') like ?', ['%' . mb_strtolower($name) . '%']);
    }

    public static function findOrCreate(
        string | array | ArrayAccess $values,
        string | null $type = null,
        string | null $locale = null,
    ): Collection | Tag | static {
        $tags = collect($values)->map(function ($value) use ($type, $locale) {
            if ($value instanceof self) {
                return $value;
            }

            return static::findOrCreateFromString($value, $type, $locale);
        });

        return is_string($values) ? $tags->first() : $tags;
    }

    public static function getWithType(string $type): DbCollection
    {
        return static::withType($type)->get();
    }

    public static function findFromString(string $name, ?string $type = null, ?string $locale = null)
    {
        $locale = $locale ?? static::getLocale();

        return static::query()
            ->where('type', $type)
            ->where(function ($query) use ($name, $locale) {
                $query->where("name->{$locale}", $name);
            })
            ->first();
    }

    public static function findFromStringOfAnyType(string $name, ?string $locale = null)
    {
        $locale = $locale ?? static::getLocale();

        return static::query()
            ->where("name->{$locale}", $name)
            ->get();
    }

    public static function findOrCreateFromString(string $name, ?string $type = null, ?string $locale = null)
    {
        $locale = $locale ?? static::getLocale();

        $tag = static::findFromString($name, $type, $locale);

        if (! $tag) {
            $tag = static::create([
                'name' => [$locale => $name],
                'slug' => str()->slug(Pinyin::convert($name)),
                'type' => $type,
            ]);
        }

        return $tag;
    }

    public static function getTypes(): Collection
    {
        return static::groupBy('type')->pluck('type');
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->translatable) && ! is_array($value)) {
            return $this->setTranslation($key, static::getLocale(), $value);
        }

        return parent::setAttribute($key, $value);
    }
}
