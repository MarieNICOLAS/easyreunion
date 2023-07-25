<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UseSpaceGroup;
use Tests\Traits\UseStripe;
use Tests\Traits\UseUserAdmin;
use Tests\Traits\UseUserPartner;

class SpaceGroupTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    use UseUserPartner, UseSpaceGroup, UseUserAdmin;


    public function test_admin_can_create_space_group()
    {
        self::user_admin();

        $name = $this->faker()->sentence(5);

        $this->actingAs(self::$user_admin)->post('/partner/space-groups/create', [
            'name' => $name,
            'address' => $this->faker()->address(),
            'city' => $this->faker()->city(),
            'zip_code' => $this->faker()->postcode(),
            'capacity_max' => $this->faker()->numberBetween(10, 1000),
            'area' => $this->faker()->numberBetween(500, 1000),
        ]);

        $this->assertDatabaseHas('space_groups', compact('name'));
    }

}
