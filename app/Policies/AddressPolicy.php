<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->rank === 'admin') {
            return true;
        }
    }

    public function update(User $user, Address $address)
    {
        return $address->user_id === $user->id;
    }
}
