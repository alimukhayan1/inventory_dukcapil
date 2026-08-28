<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class EmployeePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Employee $employee): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Employee $employee): bool
    {
        return true;
    }

    public function delete(User $user, Employee $employee): bool
    {
        // Should deactivate instead of delete, but allow if no items
        return $employee->items()->count() === 0;
    }
}
