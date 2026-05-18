# Model Pattern

## 基本結構

CMS model 通常位於 `src/Models/Xxx.php`，namespace 為 `Sharenjoy\NoahCms\Models`。

常見 trait 組合可先以內容型 model 為基準，再依需求刪減：

```php
use CommonModelTrait;
use HasCategoryTree;
use HasFactory;
use HasMediaLibrary;
use HasSEO;
use HasTags;
use HasTranslations;
use LogsActivity;
use SoftDeletes;
use SortableTrait;
```

用途判斷：

- `CommonModelTrait`：提供 `getFormFields()`、`getTableFields()`、排序與 activity log 設定。
- `HasFactory`：搭配 package factory。
- `LogsActivity`：需要 activity log 時使用。
- `SoftDeletes`：內容管理 resource 通常使用，會影響 policy 與 table actions。
- `HasTranslations`：多語欄位使用，migration 欄位通常要用 `json`。
- `SortableTrait`：需要手動排序時使用，model 要 `implements Sortable` 並有 `order_column`。
- `HasCategoryTree`：需要分類 relation 時使用；`categories` 是 `MorphToMany`，不要在本 model table 另外加 `categories` 欄位。
- `HasMediaLibrary`：需要圖片、相簿或媒體選擇時使用。
- `HasSEO`：需要 SEO tab 或 table SEO 狀態欄時使用。
- `HasTags`：需要標籤 relation 時使用。

## 欄位設定

用 model 內的 `formFields()` 與 `tableFields()` 提供 `Utils\Form` / `Utils\Table` 設定。

常見內容型 model 內部結構：

```php
protected $casts = [
    'album' => 'array',
    'is_active' => 'boolean',
    'published_at' => 'datetime',
];

public $translatable = [
    'title',
    'description',
    'content',
];

protected array $sort = [
    'order_column' => 'asc',
];
```

欄位設定可用 property 或 method。既有 model 兩種都有：

```php
protected array $formFields = [
    'left' => [
        'title' => [
            'slug' => true,
            'required' => true,
            'rules' => ['required', 'string'],
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
        'tags' => ['max' => 5, 'multiple' => true],
    ],
];

protected array $tableFields = [
    'thumbnail' => [],
    'title' => ['description' => true],
    'slug' => [],
    'categories' => [],
    'tags' => ['tagType' => 'post'],
    'seo' => [],
    'is_active' => [],
    'published_at' => [],
    'created_at' => ['isToggledHiddenByDefault' => true],
    'updated_at' => ['isToggledHiddenByDefault' => true],
];
```

若 resource 沒有 `title` / `content` 這些標準欄位，但要沿用現有表單元件，可使用 `alias`：

```php
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
```

## Trait 與欄位對應規則

表單與表格欄位要和 trait 對齊：

- 有 `HasCategoryTree` 才加入 `categories` form/table 欄位。
- 有 `HasSEO` 才加入 `seo` table 欄位；SEO form tab 由 `Utils\Form` 依 trait 自動建立，不需要在 `formFields()` 放 `seo`。
- 有 `HasMediaLibrary` 才加入 `img`、`album`、`thumbnail` 等媒體欄位。
- 有 `HasTags` 才加入 `tags` form/table 欄位，並設定正確 `tagType`。
- 有 `SortableTrait` 時通常要有 `order_column` migration 欄位與 `$sort`。
- 有 `SoftDeletes` 時 migration 要有 `softDeletes()`，policy 也要有 restore / force delete 權限。

若 model 欄位設定誤放 `categories` 或 `seo`，共用 `Utils\Form` / `Utils\Table` 應依 trait 自動跳過不相容欄位。

## Model 區塊順序

維持既有 model 的區塊註解，讓新增 model 容易掃描：

```php
/** RELACTIONS */

/** SCOPES */

/** EVENTS */

/** SEO */

/** OTHERS */
```

若使用 `HasTags` 且需要限制 tag type，可覆寫 relation：

```php
public function tags(): MorphToMany
{
    return $this
        ->morphToMany(self::getTagClassName(), $this->getTaggableMorphName(), $this->getTaggableTableName())
        ->using($this->getPivotModelClassName())
        ->where('type', 'post')
        ->ordered();
}
```

若使用 `HasSEO` 並需要前台 SEO data，可實作 `getDynamicSEOData(): SEOData`。不要假設宿主專案一定有特定前台 route；若 route 是 optional，需保護或讓宿主覆寫。

若 resource 支援複製，可在 model 實作 `getReplicateAction($type)`，並同步確認 resource permission prefixes / policy 是否包含 `replicate`。

## Factory

在 `/** OTHERS */` 下方提供 factory：

```php
protected static function newFactory()
{
    return XxxFactory::new();
}
```

## Migration

Package migration 會作用在宿主資料庫，避免假設全新專案。新增表時可以依既有 migration 模式判斷 translatable 欄位型別：

```php
if (in_array(HasTranslations::class, class_uses(Xxx::class))) {
    $fieldDataType = [
        'title' => 'json',
    ];
} else {
    $fieldDataType = [
        'title' => 'string',
    ];
}
```

常見欄位：

- `id`
- 主要內容欄位
- `order_column`，若 sortable
- `is_active`
- `timestamps`
- `softDeletes`

Factory 檔案放在 `database/factories/XxxFactory.php`，namespace 為 `Sharenjoy\NoahCms\Database\Factories`。

若 model 使用 `HasTranslations`，factory 欄位回傳 `['en' => ..., 'zh_TW' => ...]`；否則回傳字串。
