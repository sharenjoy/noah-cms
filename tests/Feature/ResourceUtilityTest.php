<?php

use Filament\Forms\Components\Component;
use Sharenjoy\NoahCms\Tests\Fixtures\ModelWithoutCategoryTree;
use Sharenjoy\NoahCms\Utils\Form;
use Sharenjoy\NoahCms\Utils\Table;

function collectFormComponentNames(array $components): array
{
    return collect($components)
        ->flatMap(function (Component $component): array {
            return array_merge(
                [method_exists($component, 'getName') ? $component->getName() : null],
                collectFormComponentNames($component->getChildComponents()),
            );
        })
        ->filter()
        ->values()
        ->all();
}

it('skips category form fields when the model does not use category tree', function () {
    expect(collectFormComponentNames(Form::make(ModelWithoutCategoryTree::class, 'create')))
        ->not->toContain('categories');
});

it('skips category table columns when the model does not use category tree', function () {
    $columnNames = collect(Table::make(ModelWithoutCategoryTree::class))
        ->map(fn ($column): string => $column->getName())
        ->all();

    expect($columnNames)->toBe(['title']);
});
