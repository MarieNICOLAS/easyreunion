<?php

namespace App\Policies;

use App\Models\Space;
use App\Models\SpaceAction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpaceActionPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->rank === 'admin')
        {
            return true;
        }
    }

    public function create(User $user, Space $space)
    {
        $spaceIds = [];
        foreach ($user->bookings as $booking)
            foreach ($booking->agendaElements()->with('agenda:id,space_id')->get()->pluck('agenda')->pluck('space_id')->toArray() as $id)
                $spaceIds[] = $id;

        return in_array($space->spaceGroup->partner_id, $user->partners()->pluck('partner_id')->toArray())
            || in_array($space->id, $spaceIds);
    }

    public function update(User $user, SpaceAction $action)
    {
        return in_array($action->space->spaceGroup->partner_id, $user->partners()->pluck('partner_id')->toArray());
    }
}
