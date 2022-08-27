<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpensePolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->hasRole("admin");
    }

    public function update(User $user): bool
    {
        return $user->hasRole("admin");
    }
    public function delete(User $user): bool
    {
        return $user->hasRole("admin");
    }
}
