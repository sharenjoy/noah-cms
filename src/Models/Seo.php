<?php

namespace Sharenjoy\NoahCms\Models;

use RalphJSmit\Laravel\SEO\Models\SEO as BaseSeo;
use Spatie\Translatable\HasTranslations;

class Seo extends BaseSeo
{
    use HasTranslations;

    public $translatable = [
        'title',
        'description',
        'author',
    ];
}
