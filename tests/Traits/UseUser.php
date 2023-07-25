<?php

namespace Tests\Traits;

use App\Models\User;

trait UseUser
{
    /**
     * @var User Utilisateur
     */
    private static User $user;

    /**
     * Initialisation de l'utilisateur si celui-ci n'a pas été fait.
     * A chaque appel de la fonction, le premier utilisateur (avec un 'rank' ayant comme valeur 'user') sera récupéré
     * s'il est possible de le récupéré, sinon un nouvel utilisateur sera créé.
     *
     * @param string|null $password
     *
     * @return User
     */
    private static function user(?string $password = null): User
    {
        if ((bool) $password) {
            $userParams['password'] = $password;
        }

        /** @var User $user */
        $user = User::factory()->createOne($userParams ?? []);
        $user->save();

        self::$user = $user;

        return $user;
    }
}
