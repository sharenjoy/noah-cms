<?php

namespace Sharenjoy\NoahCms\Models;

use Illuminate\Database\Eloquent\Model;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Country extends Model implements Sortable
{
    use CommonModelTrait;
    use LogsActivity;
    use SortableTrait;

    protected $casts = [];

    public $translatable = [];

    protected array $sort = [
        'id' => 'asc',
    ];

    protected function formFields(): array
    {
        return [];
    }

    protected function tableFields(): array
    {
        return [];
    }

    /** RELACTIONS */

    /** SCOPES */

    /** EVENTS */

    /** SEO */

    /** OTHERS */
}
