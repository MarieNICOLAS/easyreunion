<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name();

        return [
            'address_name' => "Chez {$name}",
            'customer_name' => $name,
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'zipcode' => $this->faker->postcode(),
            'country' => $this->faker->country(),
        ];
    }
}
