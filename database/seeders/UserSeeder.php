<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Sarah',
            'last_name' => 'Walker',
            'email' => 'sarah@liigem.io',
            'rank' => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);
        DB::table('users')->insert([
            'first_name' => 'Chuck',
            'last_name' => 'Bartowski',
            'email' => 'chuck@liigem.io',
            'rank' => 'partner',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);

        User::factory(3)->createQuietly();
    }
}
