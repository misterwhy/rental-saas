<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Property;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropertyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can update the property.
     */
    public function update(User $user, Property $property)
    {
        return $user->id === $property->user_id;
    }

    /**
     * Determine if the user can delete the property.
     */
    public function delete(User $user, Property $property)
    {
        return $user->id === $property->user_id;
    }

    /**
     * Determine if the user can view the property.
     */
    public function view(User $user, Property $property)
    {
        return $user->id === $property->user_id;
    }

    /**
     * Determine if the user can create a property.
     */
    public function create(User $user)
    {
        return true; // Any logged-in user can create
    }
}