<?php

namespace Sharenjoy\NoahCms\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Sharenjoy\NoahCms\NoahCmsServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            NoahCmsServiceProvider::class,
        ];
    }
}
