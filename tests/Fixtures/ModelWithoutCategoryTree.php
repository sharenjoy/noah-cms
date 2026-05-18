<?php

namespace Sharenjoy\NoahCms\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;

class ModelWithoutCategoryTree extends Model
{
    use CommonModelTrait;

    protected function formFields(): array
    {
        return [
            'left' => [],
            'right' => [
                'categories' => [],
                'seo' => [],
            ],
        ];
    }

    protected function tableFields(): array
    {
        return [
            'title' => [],
            'categories' => [],
            'seo' => [],
        ];
    }
}
