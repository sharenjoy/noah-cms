<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

abstract class TableAbstract
{
    public function __construct(
        protected string $fieldName,
        protected array $content
    ) {}

    protected function getLabel($name, $content): string
    {
        if (isset($content['label'])) {
            if (! str_contains(__('noah-cms::noah-cms.' . $content['label']), 'noah-cms')) {
                return __('noah-cms::noah-cms.' . $content['label']);
            }

            if (! str_contains(__('noah-shop::noah-shop.' . $content['label']), 'noah-shop')) {
                return __('noah-shop::noah-shop.' . $content['label']);
            }
        }

        return __('noah-cms::noah-cms.' . $name);
    }
}
