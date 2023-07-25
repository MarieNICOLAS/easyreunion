<?php

namespace App\Policies;

use App\Models\AgendaElement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgendaElementPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->rank === 'admin')
        {
            return true;
        }
    }

    public function delete(User $user, AgendaElement $element)
    {
        return in_array($element->status, ['partner_option', 'partner_confirmation'])
            && $user->partners->pluck('id')->contains($element->agenda->partner_id)
            ;
    }
    public function update(User $user, AgendaElement $element)
    {
        return in_array($element->status, ['partner_option', 'partner_confirmation'])
            && $user->partners->pluck('id')->contains($element->agenda->partner_id)
            ;
    }
}
