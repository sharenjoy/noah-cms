---
name: noah-cms-resource-builder
description: "在 sharenjoy/noah-cms Laravel package 內新增或調整 Filament CMS resource 時使用。當使用者要求建立 resource、model、migration、policy、factory、translation、config 註冊、morph map 或類似「新增 FAQ resource」「建立 BannerResource」「依 Noah CMS resource 架構新增」時觸發。"
---

# Noah CMS Resource Builder

此 skill 用於 `sharenjoy/noah-cms` package 內建立完整 CMS Resource。它假設目前專案是 Laravel package，不是宿主 app；所有實作都必須遵守 package 邊界，不可寫死宿主專案的 `App\Models`、Panel、route 或前台頁面。

## 核心原則

- 先讀 `AGENTS.md` 與 `git status --short`，確認目前 worktree 是否已有非本任務變更。
- 只改本次 resource 相關檔案；不要混入全專案格式化、無關 refactor 或既有 dirty diff。
- 優先沿用 `NoahBaseResource`、`NoahListRecords`、`NoahCreateRecord`、`NoahEditRecord`、`NoahViewRecord` 與 `Utils\Form/Table/Filter`。
- model 解析必須走 `config('noah-cms.models')`，resource class 不要直接設定 `$model`，除非既有架構已改變。
- optional package 相關依賴要用 `class_exists()`、config 或既有保護方式，避免未安裝時 class not found。
- 新增 resource 後，確認沒有未使用的語法、function、variable、property 或 dead code。
- 不要自動跑 `playwright-cli` 或 MCP。

## 工作流程

1. **探索現況**
   - 執行 `git status --short`。
   - 讀相近 resource、model、policy、migration、factory、translation 與測試。
   - 若要新增內容型 resource，優先參考 `PostResource`、`StaticPageResource`、`CarouselResource` 與最近新增的 `FaqResource`。

2. **判斷 Resource 架構**
   - 根據使用者需求判斷欄位、是否可翻譯、是否 sortable、是否 soft delete、是否需要 SEO、media、category、tags 或 relation manager。
   - 沒有明確需求時，採保守完整結構：基本欄位、`is_active`、timestamps、soft delete；內容排序需求可用 `order_column` + `SortableTrait`。
   - 需要細節時讀 `references/model-pattern.md` 與 `references/resource-pattern.md`。

3. **先補測試**
   - 新增或更新 Pest/Testbench 測試，至少驗證：
     - `config('noah-cms.models.Xxx')` 指向 model。
     - `config('noah-cms.plugins.resources')` 包含 resource。
     - resource `getModel()` 可解析 model。
     - morph map 包含 class basename。
     - policy 可被 Gate 解析。
     - model trait/formFields/tableFields 符合預期。
   - 若測試基礎不存在，補 `tests/Pest.php` 與 `tests/TestCase.php`。
   - 詳細測試樣板讀 `references/testing-pattern.md`。

4. **實作 Resource 套件檔案**
   - 建立 model、resource、resource pages、policy、migration、factory。
   - 更新 `config/noah-cms.php` 的 `models` 與 `plugins.resources`。
   - 更新 `src/NoahCmsServiceProvider.php` 的 `enforceMorphMap()` 內建 model 清單。
   - 更新 `resources/lang/zh_TW/noah-cms.php` 所需標籤。
   - 需要細節時讀：
     - `references/package-registration.md`
     - `references/policy-pattern.md`
     - `references/model-pattern.md`
     - `references/resource-pattern.md`

5. **驗證**
   - 先跑目標測試，例如 `composer test -- --filter=XxxResourceTest`。
   - 再跑 `composer test`。
   - 格式化只針對本次 resource 相關檔案，例如：
     `vendor/bin/pint path/to/file.php ...`
   - 避免直接跑全專案 `composer format`，除非使用者明確要求或準備接受全專案格式化 diff。

6. **提交邊界**
   - 如果使用者要求 commit，只 stage 本次 resource 相關檔案。
   - 提交前檢查 `git diff --cached --name-status`。
   - commit message 使用 Conventional Commits，例如：
     `feat(cms): add faq resource`
   - 不要把 `AGENTS.md`、既有 Pint-only dirty diff 或不相關檔案混入。

## 常見輸出檔案清單

以 `Faq` 為例，通常會包含：

- `src/Models/Faq.php`
- `src/Resources/FaqResource.php`
- `src/Resources/FaqResource/Pages/ListFaqs.php`
- `src/Resources/FaqResource/Pages/CreateFaq.php`
- `src/Resources/FaqResource/Pages/EditFaq.php`
- `src/Resources/FaqResource/Pages/ViewFaq.php`
- `src/Policies/FaqPolicy.php`
- `database/migrations/YYYY_MM_DD_HHMMSS_create_faqs_table.php`
- `database/factories/FaqFactory.php`
- `config/noah-cms.php`
- `src/NoahCmsServiceProvider.php`
- `resources/lang/zh_TW/noah-cms.php`
- `tests/Feature/FaqResourceTest.php`

## 完成前檢查

- Resource 已在 plugin resources 註冊。
- Model 已在 `noah-cms.models` 註冊。
- Model 已進 package morph map。
- Policy 權限 key 與 resource permission prefixes 一致。
- Translation key 不缺。
- Migration 不假設宿主資料庫是全新專案。
- 測試與格式化命令已執行，並清楚回報結果。
