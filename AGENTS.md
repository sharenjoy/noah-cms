# AGENTS.md

這份文件給 Codex 在本套件中開發時快速理解專案脈絡與維護邊界。

## 專案定位

- 這是 `sharenjoy/noah-cms` Laravel package，不是一般 Laravel app。
- 主要提供 Noah CMS 的 Filament 後台資源、模型、設定、migration、view、translation 與 assets。
- 套件會透過 `Sharenjoy\NoahCms\NoahCmsServiceProvider` 被宿主專案 auto-discover。
- Filament 後台入口是 `Sharenjoy\NoahCms\NoahCmsPlugin`，由宿主專案的 PanelProvider 註冊。

## 主要功能

- CMS 內容管理相關的 Filament Resources、Pages、Widgets 與 RelationManagers。
- 後台管理：User、Role、Permission，整合 Filament Shield / Spatie Permission。
- 內容能力：SEO、媒體庫、活動紀錄、多語欄位、樹狀分類/選單、tags、sortable。
- `config/noah-cms.php` 是主要擴充點，可覆寫 models、resources、pages、widgets、locale、feature flags。

## Package 開發原則

- 不要把宿主專案假設寫死；避免直接假設 `App\Models`、特定 route、特定 Panel、特定前台頁面一定存在。
- 若整合 optional package，例如 NoahShop，使用 `class_exists()`、config 或延遲註冊保護，避免未安裝時 class not found。
- 優先使用 `config('noah-cms.models')`、`config('noah-cms.plugins.*')` 與既有 trait/helper 擴充點。
- 修改 `config/`、`database/migrations/`、ServiceProvider 或 plugin 註冊流程時，要考慮 Laravel package 的 publish、discover、auto-discovery 與宿主覆寫行為。
- 修改 migration 要非常謹慎；package migration 會作用在宿主資料庫，不能假設是全新專案。
- 若需要 commit，以此 package repository 的 git 狀態與 diff 為準，不要把外層宿主專案或其他 package 的變更混入。
- 新增或重構後，確認沒有相依與副作用時，應移除不再使用的語法、function、variable、property 或 dead code。

## Repo-local Skills

- 新增或調整 Noah CMS Filament Resource 時，先讀 `.codex/skills/noah-cms-resource-builder/SKILL.md`。
- 適用情境包含：新增 resource、model、migration、policy、factory、translation、config 註冊、morph map、resource 測試。
- 此 skill 為 package 專用流程，應優先於一般 Laravel resource 建立方式。

## 重要檔案

- `src/NoahCmsServiceProvider.php`：package 註冊 config、routes、views、translations、migrations、assets。
- `src/NoahCmsPlugin.php`：Filament plugin 註冊 resources/pages/widgets。
- `config/noah-cms.php`：套件主要設定與宿主覆寫點。
- `src/Resources/Traits/NoahBaseResource.php`：Filament Resource 共用邏輯與 model 解析。
- `src/Utils/Form.php`、`src/Utils/Table.php`、`src/Utils/Filter.php`：依 model 設定產生 Filament 表單、表格、篩選器。
- `database/migrations/`：package migrations。
