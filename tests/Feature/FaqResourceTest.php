<?php

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Sharenjoy\NoahCms\Models\Faq;
use Sharenjoy\NoahCms\Models\Traits\HasCategoryTree;
use Sharenjoy\NoahCms\Policies\FaqPolicy;
use Sharenjoy\NoahCms\Resources\FaqResource;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

it('registers the faq model and resource through package config', function () {
    expect(config('noah-cms.models.Faq'))->toBe(Faq::class)
        ->and(config('noah-cms.plugins.resources'))->toContain(FaqResource::class)
        ->and(FaqResource::getModel())->toBe(Faq::class);
});

it('registers faq in the package morph map', function () {
    expect(Relation::morphMap())->toHaveKey('Faq', Faq::class);
});

it('defines faq as a translatable sortable content resource', function () {
    $faq = new Faq;

    expect(class_uses_recursive(Faq::class))->toContain(HasTranslations::class)
        ->and(class_uses_recursive(Faq::class))->toContain(SortableTrait::class)
        ->and(class_uses_recursive(Faq::class))->toContain(HasCategoryTree::class)
        ->and(class_uses_recursive(Faq::class))->toContain(HasSEO::class)
        ->and($faq->getFormFields())->toHaveKeys(['left', 'right'])
        ->and($faq->getFormFields()['left'])->toHaveKeys(['question', 'answer'])
        ->and($faq->getFormFields()['right'])->toHaveKey('categories')
        ->and($faq->getTableFields())->toHaveKeys(['question', 'categories', 'seo', 'is_active', 'created_at', 'updated_at']);
});

it('provides a faq policy matching the resource permission prefixes', function () {
    expect(class_exists(FaqPolicy::class))->toBeTrue()
        ->and(Gate::getPolicyFor(Faq::class))->toBeInstanceOf(FaqPolicy::class)
        ->and(FaqResource::getPermissionPrefixes())->toBe([
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'restore',
            'restore_any',
            'force_delete',
            'force_delete_any',
            'reorder',
        ]);
});
