<?php

namespace App\Policies;

use App\Models\Agenda;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgendaPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->rank === 'admin')
        {
            return true;
        }
    }

    public function show(User $user, Agenda $agenda)
    {
        return $user->partners->pluck('id')->contains($agenda->partner_id);
    }

    public function update(User $user, Agenda $agenda)
    {
        return $user->partners->pluck('id')->contains($agenda->partner_id);
    }

}
