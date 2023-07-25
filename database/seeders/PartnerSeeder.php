<?php

namespace Database\Seeders;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $partner = Partner::create([
            'type' => 'spaceowner',
            'company' => 'Forts de Liigem',
            'email' => 'forts@liigem.io',
            'phone' => '0646725125',
            'website' => 'https://liigem.io',
            'is_validated' => 1,
            'plan' => 'annuaire-plus',
        ]);

        $partner->users()->attach(User::where('email', 'chuck@liigem.io')->first());
    }
}
