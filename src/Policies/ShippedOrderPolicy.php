<?php

namespace Sharenjoy\NoahCms\Policies;

use Sharenjoy\NoahCms\Models\User;
use Sharenjoy\NoahCms\Models\ShippedOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShippedOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_shop::shipped::order');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ShippedOrder $shippedOrder): bool
    {
        return $user->can('view_shop::shipped::order');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('{{ Create }}');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ShippedOrder $shippedOrder): bool
    {
        return $user->can('{{ Update }}');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShippedOrder $shippedOrder): bool
    {
        return $user->can('{{ Delete }}');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('{{ DeleteAny }}');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, ShippedOrder $shippedOrder): bool
    {
        return $user->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, ShippedOrder $shippedOrder): bool
    {
        return $user->can('{{ Restore }}');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, ShippedOrder $shippedOrder): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('{{ Reorder }}');
    }
}
