<?php
// app/Policies/PropertyPolicy.php
namespace App\Policies;

use App\Models\User;
use App\Models\Property;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropertyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Property $property)
    {
        return $property->status === 'active' || 
               $property->user_id === $user->id || 
               $user->isAdmin();
    }

    public function create(User $user)
    {
        return $user->isLandlord() || $user->isAdmin();
    }

    public function update(User $user, Property $property)
    {
        return $property->user_id === $user->id || $user->isAdmin();
    }

    public function delete(User $user, Property $property)
    {
        return $property->user_id === $user->id || $user->isAdmin();
    }
}