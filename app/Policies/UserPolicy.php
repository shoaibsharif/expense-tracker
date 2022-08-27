<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole("admin");
    }

    public function create(User $user): bool
    {
        return $user->hasRole("admin");
    }

    public function update(User $user): bool
    {
        return $user->hasRole("admin");
    }

    public function delete($user, $record): bool
    {
        return $user->hasRole("admin") && $user->id !== $record->id;
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasRole("admin");
    }
}
