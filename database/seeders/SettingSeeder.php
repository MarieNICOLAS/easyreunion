<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Space;
use App\Models\SpaceGroup;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Featured spaces
        Setting::create([
            'key' => 'hp_featured_space_1',
            'value' => 'sp-' . Space::inRandomOrder()->first()->id,
        ]);
        Setting::create([
            'key' => 'hp_featured_space_2',
            'value' => 'sp-' . Space::inRandomOrder()->first()->id,
        ]);
        Setting::create([
            'key' => 'hp_featured_space_3',
            'value' => 'sp-' . Space::inRandomOrder()->first()->id,
        ]);
        Setting::create([
            'key' => 'hp_featured_space_4',
            'value' => 'sg-' . SpaceGroup::inRandomOrder()->first()->id,
        ]);
        Setting::create([
            'key' => 'hp_featured_space_5',
            'value' => 'sg-' . SpaceGroup::inRandomOrder()->first()->id,
        ]);
        Setting::create([
            'key' => 'hp_featured_space_6',
            'value' => 'sg-' . SpaceGroup::inRandomOrder()->first()->id,
        ]);
        Setting::create([
            'key' => 'hp_featured_space_7',
            'value' => 'sg-' . SpaceGroup::inRandomOrder()->first()->id,
        ]);
        Setting::create([
            'key' => 'hp_featured_space_8',
            'value' => 'sg-' . SpaceGroup::inRandomOrder()->first()->id,
        ]);
        Setting::create([
            'key' => 'hp_featured_space_9',
            'value' => 'sg-' . SpaceGroup::inRandomOrder()->first()->id,
        ]);


        // Exclusive spaces
        Setting::create([
            'key' => 'hp_exclusive_space_1',
            'value' => 'sp-' . Space::inRandomOrder()->first()->id,
        ]);
        Setting::create([
            'key' => 'hp_exclusive_space_2',
            'value' => 'sp-' . Space::inRandomOrder()->first()->id,
        ]);
        Setting::create([
            'key' => 'hp_exclusive_space_3',
            'value' => 'sp-' . Space::inRandomOrder()->first()->id,
        ]);
        Setting::create([
            'key' => 'hp_exclusive_space_4',
            'value' => 'sp-' . Space::inRandomOrder()->first()->id,
        ]);
        Setting::create([
            'key' => 'hp_exclusive_space_5',
            'value' => 'sp-' . Space::inRandomOrder()->first()->id,
        ]);
        Setting::create([
            'key' => 'hp_exclusive_space_6',
            'value' => 'sp-' . Space::inRandomOrder()->first()->id,
        ]);


    }
}
