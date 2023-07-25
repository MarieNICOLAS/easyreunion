<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\UseAgenda;
use Tests\Traits\UseStripe;
use Tests\Traits\UseUser;
use Tests\Traits\UseUserAdmin;
use Tests\Traits\UseUserPartner;

class AgendaTest extends TestCase
{
    use RefreshDatabase;
    use UseAgenda, UseUserPartner, UseUserAdmin, UseUser;

    public function test_partner_can_create_booking()
    {
        self::user_partner();

        $name = 'Resa ' . rand(1, 10000);
        $start = Carbon::tomorrow();
        $end = Carbon::tomorrow()->addDay();

        $agenda = self::useAgenda(self::$user_partner);
        $this->actingAs(self::$user_partner)->post('/partner/api/agendas/add-element', [
            'agenda_id' => $agenda->id,
            'start' => $start,
            'end' => $end,
            'name' => $name,
            'type' => 'partner_confirmation'
        ])->assertSuccessful();


        $this->actingAs(self::$user_partner)->get('/api/calendars/retrieve?start=' . Carbon::now()->toISOString()
            . '&end=' . Carbon::now()->addWeeks(2)->toISOString() . '&calendars=' . $agenda->id)->assertSee($name);
        $this->actingAs(self::$user_partner)->get('/api/calendars/retrieve?start=' . Carbon::now()->subDays(3)->toISOString()
            . '&end=' . Carbon::now()->subDay()->toISOString() . '&calendars=' . $agenda->id)->assertDontSee($name);
    }

    public function test_partner_can_see_calendar()
    {
        self::user_partner();

        $agenda = self::useAgenda(self::$user_partner);

        $this->actingAs(self::$user_partner)->get('/calendar')->assertSuccessful();
    }

}
