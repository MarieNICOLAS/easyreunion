<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_auth_pages()
    {
        $this->get('/login')->assertSuccessful();
        $this->get('/register')->assertSuccessful();
        $this->get('/recover-password')->assertSuccessful();
        $this->get('/reset-password')->assertSuccessful();
    }

    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        /** @var User $user */
        $user = User::factory()->make();
        $this->actingAs($user)->get('/login')->assertRedirect('/');
    }

    /*
    public function test_user_can_login_with_correct_credentials()
    {
        /** @var User $user */
       /**
        $user = User::factory()->create([
            'password' => Hash::make('erpass'),
        ]);

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'erpass'
        ])->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        /** @var User $user */
       /**
        $user = User::factory()->create([
            'password' => Hash::make('erpass'),
        ]);

        $this->from('/login')->post('/login', [
            'email'    => $user->email,
            'password' => 'invalid-password',
        ])->assertRedirect('/login');

        $this->assertGuest();
    }*/

    public function test_user_can_register()
    {
        $this->post('/register', [
            'first_name'            => 'Nathanaël',
            'last_name'             => 'Langlois',
            'email'                 => 'nathanael.langlois@liigem.io',
            'password'              => 'erpass',
            'password_confirmation' => 'erpass',
            'cgu'                   => 'true',
        ])->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'email' => 'nathanael.langlois@liigem.io',
        ]);
    }
}
