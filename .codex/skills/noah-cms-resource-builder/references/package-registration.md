# Package Registration

## config/noah-cms.php

新增 resource 時要更新兩個位置：

```php
'models' => [
    'Xxx' => \Sharenjoy\NoahCms\Models\Xxx::class,
],
```

```php
'plugins' => [
    'resources' => [
        \Sharenjoy\NoahCms\Resources\XxxResource::class,
    ],
],
```

維持檔案既有風格；若原本使用 fully qualified class，不要因為 Pint 或個人偏好改成 import class，避免 diff 擴大。

## NoahCmsServiceProvider morph map

`src/NoahCmsServiceProvider.php` 的 `enforceMorphMap()` 內建 model 清單也要加入：

```php
Models\Xxx::class,
```

雖然 `config('noah-cms.models')` 會被 merge 進 morph map，但內建 package model 仍應明確列在 `$models` 清單，方便維護與閱讀。

## Translation

`resources/lang/zh_TW/noah-cms.php` 補 resource 名稱與欄位標籤。

例：

```php
'faq' => '常見問題',
'question' => '問題',
'answer' => '回答',
```

不要順手格式化整個 translation 檔，除非使用者明確要求。

## Optional package 邊界

Noah CMS 是 package，不是宿主 app。新增功能時避免：

- 假設 `App\Models\Xxx` 一定存在。
- 假設 NoahShop class 一定存在。
- 假設特定前台 route 或 Panel ID 一定存在。

若必須整合 optional package，使用 `class_exists()`、config 或既有 helper/trait 保護。
