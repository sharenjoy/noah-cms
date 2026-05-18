<?php

namespace Sharenjoy\NoahCms\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Sharenjoy\NoahCms\Models\StaticPage;
use Sharenjoy\NoahCms\Models\User;

class StaticPagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('view_any_static::page');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User|\Sharenjoy\NoahShop\Models\User $user, StaticPage $staticPage): bool
    {
        return $user->can('view_static::page');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('create_static::page');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User|\Sharenjoy\NoahShop\Models\User $user, StaticPage $staticPage): bool
    {
        return $user->can('update_static::page');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User|\Sharenjoy\NoahShop\Models\User $user, StaticPage $staticPage): bool
    {
        return $user->can('delete_static::page');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('delete_any_static::page');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User|\Sharenjoy\NoahShop\Models\User $user, StaticPage $staticPage): bool
    {
        return $user->can('force_delete_static::page');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('force_delete_any_static::page');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User|\Sharenjoy\NoahShop\Models\User $user, StaticPage $staticPage): bool
    {
        return $user->can('restore_static::page');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('restore_any_static::page');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User|\Sharenjoy\NoahShop\Models\User $user, StaticPage $staticPage): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('{{ Reorder }}');
    }
}
