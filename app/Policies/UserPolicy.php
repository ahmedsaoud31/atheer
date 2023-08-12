<?php

namespace App\Policies;

use App\Models\User as MainModel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MainModel $model): bool
    {
        return $user->can('view users') || $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, MainModel $model): bool
    {
        return $user->can('create users') || $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MainModel $model): bool
    {
        return $user->can('update users') || $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MainModel $model): bool
    {
        return $user->can('delete users') || $user->hasRole('Super Admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MainModel $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MainModel $model): bool
    {
        //
    }
}
