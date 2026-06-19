<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

/**
 * Roofy API: Agents manage their own listings; admins manage all listings.
 */
class PropertyPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Property $property): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isAgent();
    }

    public function update(User $user, Property $property): bool
    {
        return $user->isAdmin() || ($user->isAgent() && $property->user_id === $user->id);
    }

    public function delete(User $user, Property $property): bool
    {
        return $user->isAdmin() || ($user->isAgent() && $property->user_id === $user->id);
    }
}
