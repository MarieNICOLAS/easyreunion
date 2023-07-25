<?php

namespace Tests\Traits;

use App\Models\Agenda;

/**
 * Permet aux tests unitaires de manipuler les agendas plus facilement.
 */
trait UseAgenda
{
    use UseSpace;

    /**
     * @param $user
     *
     * @return Agenda
     */
    private function useAgenda($user): Agenda
    {
        $partner = $user->selectedPartner();
        $agenda = $partner->agendas()->first();

        if (! $agenda) {
            $space = $this->useSpace($user);
            $agenda = $space->agenda;
        }

        return $agenda;
    }
}
