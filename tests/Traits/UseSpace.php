<?php

namespace Tests\Traits;

use App\Models\Space;
use App\Models\SpaceGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Permet aux tests unitaires de manipuler les salles plus facilement.
 */
trait UseSpace
{
    /**
     * Initialisation d'une salle si celui-ci n'a pas été fait.
     * Dans le cas où la salle doit être créé, un espace sera créé et sera attaché à l'espace.
     *
     * @param $user User Utilisateur partenaire ou administrateur
     *
     * @return Space Salle d'un espace
     */
    private function useSpace(User $user): Space
    {
        $partner = $user->selectedPartner();
        $space_group = $partner->spaceGroups()->first();

        if (! $space_group) {
            $space_group = SpaceGroup::factory()->createOne(['partner_id' => $partner->id]);
            $space_group->save();
        }

        $space = $space_group->spaces()->first();

        if (! $space) {
            $space = Space::factory()->createOne(['space_group_id' => $space_group->id]);
            $space->save();
        }

        return $space;
    }
}
