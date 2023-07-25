<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\UseStripe;
use Tests\Traits\UseUser;
use Tests\Traits\UseUserAdmin;
use Tests\Traits\UseUserPartner;

class PartnerTest extends TestCase
{
    use RefreshDatabase;
    use UseUserPartner, UseUserAdmin, UseUser;

    // test utilisateur partenaires

    public function test_partner_can_see_partner_pages()
    {
        self::user_partner();

        $this->actingAs(self::$user_partner)->get('/partner/bookings')->assertSuccessful();
        $this->actingAs(self::$user_partner)->get('/partner/space-groups')->assertSuccessful();
        $this->actingAs(self::$user_partner)->get('/partner/team')->assertSuccessful();
        $this->actingAs(self::$user_partner)->get('/partner/settings')->assertSuccessful();
    }

}
