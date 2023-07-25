<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

class PageTest extends TestCase
{
    use RefreshDatabase;


    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }


    public function test_guest_pages_access()
    {
        $this->get('/')->assertSuccessful();
        $this->get('/location-salle')->assertSuccessful();
        $this->get('/qui-sommes-nous')->assertSuccessful();
        $this->get('/notre-equipe')->assertSuccessful();
        $this->get('/jobs')->assertSuccessful();
        $this->get('/login')->assertSuccessful();
        $this->get('/register')->assertSuccessful();
        $this->get('/recover-password')->assertSuccessful();

        foreach (Page::all() as $page)
        {
            $this->get('/pages/' . $page->slug)->assertSuccessful();
        }
    }

    public function test_contact_endpoint()
    {

        Mail::fake();


        $this->post('/contact', [
            'name' => 'Chuck Bartowski',
            'email' => 'team@easyreunion.fr',
            'phone' => '0600000000',
            'message' => 'This is a test message',
        ])->assertRedirect();
    }

}
