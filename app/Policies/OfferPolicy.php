<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfferPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->rank === 'admin') {
            return true;
        }
    }
}
