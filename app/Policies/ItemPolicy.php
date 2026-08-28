<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;

class ItemPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Item $item): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Item $item): bool
    {
        return true;
    }

    public function delete(User $user, Item $item): bool
    {
        return true; // Soft delete
    }

    public function restore(User $user, Item $item): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Item $item): bool
    {
        return false; // No permanent delete through UI
    }
}
