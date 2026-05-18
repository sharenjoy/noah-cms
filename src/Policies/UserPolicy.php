<?php

namespace Sharenjoy\NoahCms\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Sharenjoy\NoahCms\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     */
    public function viewAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('view_any_user');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     */
    public function view(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('view_user');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     */
    public function create(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('create_user');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     */
    public function update(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('update_user');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     */
    public function delete(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('delete_user');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  User  $user
     */
    public function deleteAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('delete_any_user');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  User  $user
     */
    public function forceDelete(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('force_delete_user');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  User  $user
     */
    public function forceDeleteAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('force_delete_any_user');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  User  $user
     */
    public function restore(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('restore_user');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  User  $user
     */
    public function restoreAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('restore_any_user');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  User  $user
     */
    public function replicate(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  User  $user
     */
    public function reorder(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('{{ Reorder }}');
    }
}
