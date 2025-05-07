<?php

namespace Sharenjoy\NoahCms\Commands;

use Illuminate\Console\Command;
use Sharenjoy\NoahCms\Actions\Shop\ResolveObjectiveTarget;
use Sharenjoy\NoahCms\Models\Objective;

class UpdateObjectiveTargets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'noah-cms:update-objective-targets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update objective target';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $objectives = Objective::orderBy('created_at', 'desc')->get();

        foreach ($objectives as $objective) {
            dispatch(ResolveObjectiveTarget::makeJob($objective));
        }

        $this->info('Objectives updated successfully.');
    }
}
