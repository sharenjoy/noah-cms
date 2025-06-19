<?php

namespace Sharenjoy\NoahCms\Actions\Shop;

use Lorisleiva\Actions\Concerns\AsAction;

class RoleCan
{
    use AsAction;

    public function handle(string $role): bool
    {
        $user = request()->user();

        if (! $user) {
            return false;
        }

        if ($role == 'creator') {
            if (in_array($user->email, config('noah-cms.creator_emails'))) {
                return true;
            }

            return false;
        }

        if ($user->hasRole($role)) {
            return true;
        }

        return false;
    }
}
