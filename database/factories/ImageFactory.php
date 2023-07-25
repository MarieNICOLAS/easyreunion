<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'file' => Arr::random([
                'https://www.easyreunion.fr/system/salles/photo1s/1/original/Rue_de_Grenelle-11.jpg.jpg?1525185229',
                'https://www.easyreunion.fr/system/salles/photo2s/1/original/DSC_0273-grenelle.jpg.jpg?1549383617',
                'https://www.easyreunion.fr/system/salles/photo3s/1/original/Rue_de_Grenelle-3.jpg.jpg?1525185229',
                'https://www.easyreunion.fr/system/salles/photo4s/1/original/DSC_0488-ER.jpg.jpg?1550844289',
            ], 1)[0],
        ];
    }
}
