<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tests\Traits\UseUserAdmin;
use Tests\Traits\UseUserPartner;

class SettingsTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    use UseUserPartner, UseUserAdmin;

    public function test_partner_can_see_settings_pages()
    {
        self::user_partner();
        $this->actingAs(self::$user_partner)->get('/settings')->assertSuccessful();
    }

    public function test_partner_can_update_settings()
    {
        self::user_partner();
        $email = $this->faker()->email;
        $password = $this->faker()->password;
        $id = self::$user_partner->id;

        $this->actingAs(self::$user_partner)->put('/settings', compact('password', 'email'));
        $this->assertDatabaseHas('users', compact('id', 'email'));
        $this->assertTrue(Hash::check($password, self::$user_partner->getAuthPassword()));
    }

    /*
     * Tests administrateurs
     */

    public function test_admin_can_see_settings_pages()
    {
        self::refreshDatabase();
        self::user_admin();
        $this->actingAs(self::$user_partner)->get('/settings')->assertSuccessful();
    }

    public function test_admin_can_update_settings()
    {
        self::refreshDatabase();
        self::user_admin();

        $email = $this->faker()->email;
        $password = $this->faker()->password;
        $id = self::$user_admin->id;

        $this->actingAs(self::$user_admin)->put('/settings', compact('password', 'email'));
        $this->assertDatabaseHas('users', compact('id', 'email'));
        $this->assertTrue(Hash::check($password, self::$user_admin->getAuthPassword()));
    }
}
