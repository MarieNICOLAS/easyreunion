<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Space;
use App\Models\SpaceGroup;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class SpaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = Tag::types()->flip();
        $accesses = Tag::accesses()->flip();

        $spaceGroups = SpaceGroup::factory()->count(3)->create();

        foreach ($spaceGroups as $spaceGroup) {
            Space::factory()->state(['space_group_id' => $spaceGroup->id])->count(1)->create();

            foreach (Space::all() as $space) {
                $space->tags()->attach($types->random());
                if (20 > rand(0,100)) {
                    $space->tags()->attach($accesses->random());
                }
            }
        }
    }
}
