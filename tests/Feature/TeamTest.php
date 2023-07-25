<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\Traits\UseUserAdmin;
use Tests\Traits\UseUserPartner;

class TeamTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    use UseUserPartner, UseUserAdmin;

    public function test_partner_can_see_team_page()
    {
        self::user_partner();
        $this->actingAs(self::$user_partner)->get('/partner/team')->assertSuccessful();
    }

    public function test_partner_can_invite_user()
    {
        self::user_partner();
        $email = $this->faker()->email;

        $this->actingAs(self::$user_partner)->post('/partner/team', [
            'email'      => $email,
            'first_name' => $this->faker()->firstname(),
            'last_name'  => $this->faker()->lastname(),
        ]);

        $this->assertDatabaseHas('users', compact('email'));
    }

    public function test_partner_can_remove_user()
    {
        self::user_partner();
        $password = Str::random();
        $first_name = $this->faker()->firstname();
        $last_name = $this->faker()->lastname();
        $email = $this->faker()->email();
        $user = User::create([
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email,
            'password'   => Hash::make($password),
            'rank'       => 'partner',
        ]);
        $user_id = $user->id;

        $this->actingAs(self::$user_partner)
             ->post('/partner/team', compact('email', 'first_name', 'last_name'))
             ->assertRedirect();

        $this->actingAs(self::$user_partner)->get("/partner/team/{$user->id}/remove")->assertRedirect();
        $this->assertDatabaseMissing('partner_user', compact('user_id'));
    }
}
