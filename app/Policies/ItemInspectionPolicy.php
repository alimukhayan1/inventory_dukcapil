<?php

namespace App\Policies;

use App\Models\ItemInspection;
use App\Models\User;

class ItemInspectionPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ItemInspection $inspection): bool
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
    public function update(User $user, ItemInspection $inspection): bool
    {
        return false;
    }

    /**
     * Historical data: no delete through UI.
     */
    public function delete(User $user, ItemInspection $inspection): bool
    {
        return false;
    }
}
