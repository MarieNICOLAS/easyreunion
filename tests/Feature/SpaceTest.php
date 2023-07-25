<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\UseSpace;
use Tests\Traits\UseSpaceGroup;
use Tests\Traits\UseStripe;
use Tests\Traits\UseUserAdmin;
use Tests\Traits\UseUserPartner;

class SpaceTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    use UseUserPartner, UseUserAdmin, UseSpace, UseSpaceGroup;


    /*
     * Tests avec un compte administrateur
     */

    public function test_admin_can_see_spaces_pages()
    {
        self::refreshDatabase();
        self::user_admin();

        $space = $this->useSpace(self::$user_admin);
        $space_group = $space->spaceGroup;

        $this->actingAs(self::$user_admin)
             ->get("/espaces/{$space_group->slug}")
             ->assertSuccessful();

    }

    public function test_admin_can_create_space()
    {
        self::user_admin();

        $space_group = $this->useSpaceGroup(self::$user_admin);
        $name = $this->faker()->sentence(7);
        $space_group_id = $space_group->id;

        $this->actingAs(self::$user_admin)->post("/partner/space-groups/{$space_group->slug}/space/create", [
            'name'         => $name,
            'capacity_max' => $this->faker()->numberBetween(10, 1000),
            'area'         => $this->faker()->numberBetween(500, 1000),
        ]);

        $this->assertDatabaseHas('spaces', compact('space_group_id', 'name'));
    }

}
