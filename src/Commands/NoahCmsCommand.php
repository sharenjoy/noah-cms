<?php

namespace Sharenjoy\NoahCms\Commands;

use Illuminate\Console\Command;

class NoahCmsCommand extends Command
{
    public $signature = 'noah-cms';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
