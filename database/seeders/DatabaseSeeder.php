<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(PartnerSeeder::class);
        $this->call(SpaceSeeder::class);
        $this->call(SettingSeeder::class);
    }
}
