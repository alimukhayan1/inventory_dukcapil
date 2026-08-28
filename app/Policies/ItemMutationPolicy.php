<?php

namespace App\Policies;

use App\Models\ItemMutation;
use App\Models\User;

class ItemMutationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ItemMutation $mutation): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Historical data: no edit through UI.
     */
    public function update(User $user, ItemMutation $mutation): bool
    {
        return false;
    }

    /**
     * Historical data: no delete through UI.
     */
    public function delete(User $user, ItemMutation $mutation): bool
    {
        return false;
    }
}
