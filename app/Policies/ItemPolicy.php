<?php

namespace App\Policies;

use App\Models\AuthUser;
use App\Models\Item;
use Illuminate\Auth\Access\Response;    

class ItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */

    // public function viewAny(AuthUser $authUser): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can view the model.
     */
    // public function view(AuthUser $authUser, Item $item): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can create models.
     */
    // public function create(AuthUser $authUser): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can update the model.
     */
    public function update(AuthUser $authUser, Item $item): bool
    {
            return in_array($authUser->role, ['admin', 'editor']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(AuthUser $authUser, Item $item): bool
    {
            return $authUser->role === 'admin';

    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(AuthUser $authUser, Item $item): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(AuthUser $authUser, Item $item): bool
    // {
    //     //
    // }
}
