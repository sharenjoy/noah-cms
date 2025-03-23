<?php

namespace Sharenjoy\NoahCms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sharenjoy\NoahCms\NoahCms
 */
class NoahCms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Sharenjoy\NoahCms\NoahCms::class;
    }
}
