<?php

namespace Tests\Traits;

use App\Models\Address;

/**
 * Permet aux tests unitaires de manipuler les adresses plus facilement.
 */
trait UseAddress
{
    private function useAddress($user): Address
    {
        return Address::factory()->createOne([
            'user_id'       => $user->id,
            'customer_name' => "{$user->first_name} {$user->last_name}",
        ]);
    }
}
