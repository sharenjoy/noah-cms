<?php

namespace Sharenjoy\NoahCms\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Sharenjoy\NoahCms\Models\Category;
use Sharenjoy\NoahCms\Models\User;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('view_any_category');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User|\Sharenjoy\NoahShop\Models\User $user, Category $category): bool
    {
        return $user->can('view_category');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('create_category');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User|\Sharenjoy\NoahShop\Models\User $user, Category $category): bool
    {
        return $user->can('update_category');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User|\Sharenjoy\NoahShop\Models\User $user, Category $category): bool
    {
        return $user->can('delete_category');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('delete_any_category');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User|\Sharenjoy\NoahShop\Models\User $user, Category $category): bool
    {
        return $user->can('force_delete_category');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('force_delete_any_category');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User|\Sharenjoy\NoahShop\Models\User $user, Category $category): bool
    {
        return $user->can('restore_category');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('restore_any_category');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User|\Sharenjoy\NoahShop\Models\User $user, Category $category): bool
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
