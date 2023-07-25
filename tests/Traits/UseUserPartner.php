<?php

namespace Tests\Traits;

use App\Models\Partner;
use App\Models\User;

/**
 * Permet aux tests unitaires de manipuler les utilisateurs partenaires plus facilement.
 */
trait UseUserPartner
{
    /**
     * @var User Utilisateur partenaire
     */
    private static User $user_partner;

    /**
     * Initialisation de l'utilisateur partenaire si celui-ci n'a pas été fait.
     * Dans le cas où l'utilisateur doit être créé, un partenaire sera créé et attaché à l'utilisateur.
     * A chaque appel de la fonction, un nouvel utilisateur sera créé.
     *
     * @param string|null $password
     *
     * @return User
     */
    private static function user_partner(?string $password = null)
    {
        $partner = Partner::factory()->createOne(['type' => 'spaceowner']);
        $partner->save();

        $userParams = ['rank' => 'partner'];

        if ((bool) $password) {
            $userParams['password'] = $password;
        }

        /** @var User $user */
        $user = User::factory()->createOne($userParams);
        $user->partners()->attach($partner->id);
        $user->save();

        self::$user_partner = $user;

        return $user;
    }
}
