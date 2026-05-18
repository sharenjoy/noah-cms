# Model Pattern

## 基本結構

CMS model 通常位於 `src/Models/Xxx.php`，namespace 為 `Sharenjoy\NoahCms\Models`。

常見 trait：

- `CommonModelTrait`
- `HasFactory`
- `LogsActivity`
- `SoftDeletes`
- `HasTranslations`，用於多語欄位
- `SortableTrait`，搭配 `implements Sortable` 與 `order_column`
- 依需求加入 `HasMediaLibrary`、`HasCategoryTree`、`HasTags`、`HasSEO`

## 欄位設定

用 model 內的 `formFields()` 與 `tableFields()` 提供 `Utils\Form` / `Utils\Table` 設定。

常見內容型 resource：

```php
protected $casts = [
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

## Factory

Factory 放在 `database/factories/XxxFactory.php`，namespace 為 `Sharenjoy\NoahCms\Database\Factories`。

若 model 使用 `HasTranslations`，factory 欄位回傳 `['en' => ..., 'zh_TW' => ...]`；否則回傳字串。
