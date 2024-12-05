<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return ! $user->hasRole(RoleType::patient->value);
    }

    public function view(User $user): bool
    {
        return ! $user->hasRole(RoleType::patient->value);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(RoleType::receptionist->value) || $user->hasRole(RoleType::admin->value);
    }

    public function update(User $user): bool
    {
        return ! $user->hasRole(RoleType::patient->value);
    }

    public function delete(User $user): bool
    {
        return $user->hasRole(RoleType::receptionist->value) || $user->hasRole(RoleType::admin->value);
    }
}
