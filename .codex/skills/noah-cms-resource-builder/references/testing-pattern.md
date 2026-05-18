# Testing Pattern

## Testbench 基礎

若 repo 尚未有測試基礎，補：

`tests/TestCase.php`

```php
namespace Sharenjoy\NoahCms\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Sharenjoy\NoahCms\NoahCmsServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            NoahCmsServiceProvider::class,
        ];
    }
}
```

`tests/Pest.php`

```php
use Sharenjoy\NoahCms\Tests\TestCase;

uses(TestCase::class)->in('Feature');
```

## Resource 測試項目

新增 `tests/Feature/XxxResourceTest.php`，至少涵蓋：

- config model 註冊。
- plugin resources 註冊。
- resource `getModel()` 解析。
- package morph map 註冊。
- model traits 與 `formFields()` / `tableFields()`。
- policy class 存在、Gate 可解析、permission prefixes 正確。

範例：

```php
it('registers the xxx model and resource through package config', function () {
    expect(config('noah-cms.models.Xxx'))->toBe(Xxx::class)
        ->and(config('noah-cms.plugins.resources'))->toContain(XxxResource::class)
        ->and(XxxResource::getModel())->toBe(Xxx::class);
});

it('registers xxx in the package morph map', function () {
    expect(Relation::morphMap())->toHaveKey('Xxx', Xxx::class);
});
```

## 驗證命令

先跑目標測試：

```bash
composer test -- --filter=XxxResourceTest
```

再跑完整 package 測試：

```bash
composer test
```

格式化只針對本次相關檔案：

```bash
vendor/bin/pint src/Models/Xxx.php src/Resources/XxxResource.php tests/Feature/XxxResourceTest.php
```

避免直接跑 `composer format`，因為它可能格式化大量既有檔案並污染本次 diff。
