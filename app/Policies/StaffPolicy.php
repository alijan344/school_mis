<?php

namespace App\Policies;

use App\Models\Staff;
use App\Models\User;

class StaffPolicy
{
    private function isAdmin(User $user): bool
    {
        return (int) ($user->userLevel?->admin_level ?? 0) >= 1;
    }

    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function view(User $user, Staff $staff): bool
    {
        return $this->isAdmin($user)
            || (int) $user->staff_id === (int) $staff->staff_id;
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Staff $staff): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, Staff $staff): bool
    {
        return $this->isAdmin($user);
    }
}