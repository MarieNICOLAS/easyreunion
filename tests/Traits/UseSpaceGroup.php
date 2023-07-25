<?php

namespace Tests\Traits;

use App\Models\SpaceGroup;
use App\Models\User;

/**
 * Permet aux tests unitaires de manipuler les espaces plus facilement.
 */
trait UseSpaceGroup
{
    /**
     * Initialisation d'un espace si celui-ci n'a pas été fait.
     *
     * @param $user User Utilisateur partenaire ou administrateur
     *
     * @return SpaceGroup Espace
     */
    private static function useSpaceGroup(User $user): SpaceGroup
    {
        $partner = $user->selectedPartner();
        $space_group = $partner->spaceGroups()->first();

        if (! $space_group) {
            $space_group = SpaceGroup::factory()->createOne(['partner_id' => $partner->id]);
            $space_group->save();
        }

        return $space_group;
    }
}
