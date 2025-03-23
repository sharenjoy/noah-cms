<?php

namespace Sharenjoy\NoahCms\Policies;

use Sharenjoy\NoahCms\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class Policy
{
    use HandlesAuthorization;

    /**
     * The Permission key the Policy corresponds to.
     *
     * @var string
     */
    public static $key;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_' . static::$key);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, $modal): bool
    {
        return $user->can('view_' . static::$key);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_' . static::$key);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, $modal): bool
    {
        return $user->can('update_' . static::$key);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function replicate(User $user, $modal): bool
    {
        return $user->can('replicate_' . static::$key);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, $modal): bool
    {
        return $user->can('delete_' . static::$key);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_' . static::$key);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, $modal): bool
    {
        return $user->can('restore_' . static::$key);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_' . static::$key);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, $modal): bool
    {
        return $user->can('force_delete_' . static::$key);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_' . static::$key);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_' . static::$key);
    }
}
