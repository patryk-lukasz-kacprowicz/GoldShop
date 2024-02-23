<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Spatie\Activitylog\Models\Activity as ActivityModel;

class ActivityPolicy
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
    public function view(User $user, ActivityModel $activityModel): bool
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
    public function update(User $user, ActivityModel $activityModel): bool
    {
        return $user->hasRole([UserRoleEnum::Administrator]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ActivityModel $activityModel): bool
    {
        return $user->hasRole([UserRoleEnum::Administrator]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ActivityModel $activityModel): bool
    {
        return $user->hasRole([UserRoleEnum::Administrator]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ActivityModel $activityModel): bool
    {
        return $user->hasRole([UserRoleEnum::Administrator]);
    }
}
