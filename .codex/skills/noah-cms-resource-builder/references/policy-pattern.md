# Policy Pattern

## 檔案位置

Policy 放在 `src/Policies/XxxPolicy.php`，namespace 為 `Sharenjoy\NoahCms\Policies`。

標準結構：

```php
use Illuminate\Auth\Access\HandlesAuthorization;
use Sharenjoy\NoahCms\Models\User;
use Sharenjoy\NoahCms\Models\Xxx;

class XxxPolicy
{
    use HandlesAuthorization;
}
```

user type 依既有 policy 慣例使用：

```php
User|\Sharenjoy\NoahShop\Models\User $user
```

## 權限命名

權限 key 使用 Filament Shield 的 resource basename snake case：

- `view_any_xxx`
- `view_xxx`
- `create_xxx`
- `update_xxx`
- `delete_xxx`
- `delete_any_xxx`
- `restore_xxx`
- `restore_any_xxx`
- `force_delete_xxx`
- `force_delete_any_xxx`
- `reorder_xxx`
- `replicate_xxx`，只有 model/resource 真的支援 replicate 時才加入

若 model 使用 `SoftDeletes`，policy 需包含 restore / force delete 系列。

若 model 使用 `SortableTrait`，policy 需包含 `reorder()`。

若 model 沒有 `getReplicateAction()`，不要加入 `replicate()`，避免與 resource permission prefixes 不一致。

## 測試

測試至少確認：

```php
expect(class_exists(XxxPolicy::class))->toBeTrue()
    ->and(Gate::getPolicyFor(Xxx::class))->toBeInstanceOf(XxxPolicy::class)
    ->and(XxxResource::getPermissionPrefixes())->toBe([...]);
```
