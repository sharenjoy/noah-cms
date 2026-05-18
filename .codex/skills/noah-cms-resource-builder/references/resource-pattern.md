# Resource Pattern

## Resource class

新增 CMS resource 時，優先沿用既有 resource 結構：

- namespace：`Sharenjoy\NoahCms\Resources`
- extends：`Filament\Resources\Resource`
- implements：`BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions`
- trait：`Sharenjoy\NoahCms\Resources\Traits\NoahBaseResource`
- 不直接設定 `$model`，讓 `NoahBaseResource::getModel()` 從 `config('noah-cms.models')` 解析。

常見方法：

- `getNavigationGroup()` 回傳 `__('noah-cms::noah-cms.resource')`
- `getModelLabel()` 回傳 resource translation key
- `form()` 使用 `\Sharenjoy\NoahCms\Utils\Form::make(static::getModel(), $form->getOperation())`
- `table()` 先跑 `static::chainTableFunctions($table)`，再接 `Utils\Table::make()` 與 `Utils\Filter::make()`
- `getPermissionPrefixes()` 回傳 `array_merge(static::getCommonPermissionPrefixes(), [])`

## Pages

每個標準 resource 建立 4 個 page：

- `ListXxxs extends ListRecords`，使用 `NoahListRecords`
- `CreateXxx extends CreateRecord`，使用 `NoahCreateRecord`
- `EditXxx extends EditRecord`，使用 `NoahEditRecord`
- `ViewXxx extends ViewRecord`，使用 `NoahViewRecord`

每個 page 都設定：

```php
protected static string $resource = XxxResource::class;

protected function getHeaderActions(): array
{
    return array_merge([], $this->recordHeaderActions());
}
```

## Navigation

依既有排序選擇 `navigationSort`，不要任意重排其他 resource。icon 使用 Heroicons，挑與 resource 語意接近的 outline icon。
