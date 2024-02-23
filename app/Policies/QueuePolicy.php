<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use \Croustibat\FilamentJobsMonitor\Models\QueueMonitor as QueueModel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QueuePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole([UserRoleEnum::Administrator]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, QueueModel $queueModel): bool
    {
        return $user->hasRole([UserRoleEnum::Administrator]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole([UserRoleEnum::Administrator]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, QueueModel $queueModel): bool
    {
        return $user->hasRole([UserRoleEnum::Administrator]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, QueueModel $queueModel): bool
    {
        return $user->hasRole([UserRoleEnum::Administrator]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, QueueModel $queueModel): bool
    {
        return $user->hasRole([UserRoleEnum::Administrator]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, QueueModel $queueModel): bool
    {
        return $user->hasRole([UserRoleEnum::Administrator]);
    }
}
