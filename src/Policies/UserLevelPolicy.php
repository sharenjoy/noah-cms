<?php

namespace Sharenjoy\NoahCms\Policies;

use Sharenjoy\NoahCms\Models\User;
use Sharenjoy\NoahCms\Models\UserLevel;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserLevelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_shop::user::level');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserLevel $userLevel): bool
    {
        return $user->can('view_shop::user::level');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_shop::user::level');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserLevel $userLevel): bool
    {
        return $user->can('update_shop::user::level');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserLevel $userLevel): bool
    {
        return $user->can('delete_shop::user::level');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_shop::user::level');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, UserLevel $userLevel): bool
    {
        return $user->can('force_delete_shop::user::level');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_shop::user::level');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, UserLevel $userLevel): bool
    {
        return $user->can('restore_shop::user::level');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_shop::user::level');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, UserLevel $userLevel): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_shop::user::level');
    }
}
