<?php

namespace App\Policies;

use App\Models\Aboutme;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AboutmePolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user -> is_admin) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Aboutme $aboutme): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Aboutme $aboutme): bool
    {
        return $user->id === $aboutme->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Aboutme $aboutme): bool
    {
        return $user->id === $aboutme->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Aboutme $aboutme): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Aboutme $aboutme): bool
    {
        //
    }
}
