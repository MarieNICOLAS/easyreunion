<?php

namespace Database\Factories;

use App\Models\Partner;
use App\Models\SpaceGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class SpaceGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $partners = Partner::type('spaceowner')->get();

        return [
            'name' => 'SG '.$this->faker->unique()->word(),
            'city' => Arr::random(['Paris', 'Marseille', 'Toulouse', 'Pommeuse']),
            'slug' => $this->faker->slug,
            'zip_code' => $this->faker->postcode(),
            'address' => $this->faker->streetAddress(),
            'access' => $this->faker->text(300),
            'partner_id' => $partners->random()->id,
            'status' => 'online'
        ];
    }
}
