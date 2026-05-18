<?php

namespace Sharenjoy\NoahCms\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Sharenjoy\NoahCms\Models\Faq;
use Sharenjoy\NoahCms\Models\User;

class FaqPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('view_any_faq');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User|\Sharenjoy\NoahShop\Models\User $user, Faq $faq): bool
    {
        return $user->can('view_faq');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('create_faq');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User|\Sharenjoy\NoahShop\Models\User $user, Faq $faq): bool
    {
        return $user->can('update_faq');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User|\Sharenjoy\NoahShop\Models\User $user, Faq $faq): bool
    {
        return $user->can('delete_faq');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('delete_any_faq');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User|\Sharenjoy\NoahShop\Models\User $user, Faq $faq): bool
    {
        return $user->can('force_delete_faq');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('force_delete_any_faq');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User|\Sharenjoy\NoahShop\Models\User $user, Faq $faq): bool
    {
        return $user->can('restore_faq');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('restore_any_faq');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User|\Sharenjoy\NoahShop\Models\User $user): bool
    {
        return $user->can('reorder_faq');
    }
}
