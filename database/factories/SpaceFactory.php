<?php

namespace Database\Factories;

use App\Models\Space;
use App\Models\SpaceGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $spaceGroups = SpaceGroup::all()->pluck('id');
        $spaceGroupId = $spaceGroups->random();

        return [
            'space_group_id' => $spaceGroupId,
            'slug' => $this->faker->slug,
            'name' => 'SP '.$this->faker->unique()->word(),
            'capacity_min' => ($min = random_int(1, 50)),
            'capacity_max' => $min + random_int(0, 200),
            'area' => random_int(10, 200)
        ];
    }
}
