<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MediaPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->rank === 'admin')
        {
            return true;
        }
    }

    public function delete()
    {
        return false;
    }

    public function update()
    {
        return false;
    }
}
