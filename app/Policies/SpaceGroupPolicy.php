<?php

namespace App\Policies;

use App\Models\SpaceGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpaceGroupPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->rank === 'admin')
        {
            return true;
        }
    }

    public function create()
    {
        return false;
    }

    public function update(User $user, SpaceGroup $spaceGroup)
    {
        return false;

        // return in_array($spaceGroup->partner_id, $user->partners()->pluck('partner_id')->toArray());
    }
}
