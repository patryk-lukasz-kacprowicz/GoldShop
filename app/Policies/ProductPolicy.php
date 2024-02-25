<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            UserRoleEnum::Administrator, UserRoleEnum::ProductManager,
        ]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        return $user->hasAnyRole([
            UserRoleEnum::Administrator, UserRoleEnum::ProductManager,
        ]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(
            UserRoleEnum::Administrator
        );
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        $result = $user->hasAnyRole([
            UserRoleEnum::Administrator, UserRoleEnum::ProductManager,
        ]);

        if (!($product->assignedTo->id == $user->getKey()) && !$user->hasRole(UserRoleEnum::Administrator)) {
            $result = false;
        }

        return $result;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->hasRole(
            UserRoleEnum::Administrator
        );
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return $user->hasRole(
            UserRoleEnum::Administrator
        );
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return $user->hasRole(
            UserRoleEnum::Administrator
        );
    }
}
