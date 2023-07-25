<?php

namespace Tests\Traits;

use App\Models\Partner;
use App\Models\User;

trait UseUserAdmin
{
    /**
     * @var User Utilisateur administrateur
     */
    private static User $user_admin;

    /**
     * Initialisation de l'utilisateur partenaire si celui-ci n'a pas été fait.
     * Dans le cas où l'utilisateur doit être créé, un partenaire sera créé et attaché à l'utilisateur.
     * A chaque appel de la fonction, le premier administrateur sera récupéré si il est possible de le récupéré,
     * sinon un nouvel administrateur.
     *
     * @param string|null $password
     *
     * @return User
     */
    private static function user_admin(?string $password = null): User
    {
        $partner = Partner::factory()->createOne(['type' => 'spaceowner']);
        $partner->save();

        $userParams = ['rank' => 'admin'];

        if ((bool) $password) {
            $userParams['password'] = $password;
        }

        /** @var User $user */
        $user = User::factory()->createOne($userParams);
        $user->partners()->attach($partner->id);
        $user->save();

        self::$user_admin = $user;

        return $user;
    }
}
