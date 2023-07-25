<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            // Attributes
            ['type' => 'attribute', 'name' => 'verified'],
            ['type' => 'attribute', 'name' => 'erp'],

            // Type
            ['type' => 'type', 'name' => 'meeting'],
            ['type' => 'type', 'name' => 'workplace'],
            ['type' => 'type', 'name' => 'coworking'],
            ['type' => 'type', 'name' => 'training'],
            ['type' => 'type', 'name' => 'conference'],
            ['type' => 'type', 'name' => 'seminar'],
            ['type' => 'type', 'name' => 'amphitheater'],
            ['type' => 'type', 'name' => 'cocktail'],
            ['type' => 'type', 'name' => 'salon'],
            ['type' => 'type', 'name' => 'workshop'],
            ['type' => 'type', 'name' => 'teambuilding'],

            // Materiels
            ['type' => 'material', 'name' => 'projector'],
            ['type' => 'material', 'name' => 'paperboard'],
            ['type' => 'material', 'name' => 'wifi'],
            ['type' => 'material', 'name' => 'chairs'],
            ['type' => 'material', 'name' => 'tables'],
            ['type' => 'material', 'name' => 'cloakrooms'], // Vestiaires
            ['type' => 'material', 'name' => 'projector_screen'],
            ['type' => 'material', 'name' => 'videoconference'],
            ['type' => 'material', 'name' => 'wired_microphone'],
            ['type' => 'material', 'name' => 'wireless_microphone'],
            ['type' => 'material', 'name' => 'sound_reinforcement_system'], // Sonorisation
            ['type' => 'material', 'name' => 'overhead_projector'], // Retroprojecteur
            ['type' => 'material', 'name' => 'light_spots'],
            ['type' => 'material', 'name' => 'armchairs'],
            ['type' => 'material', 'name' => 'hostesses'], //  Hôtesse(s) d'accueil
            ['type' => 'material', 'name' => 'platform'], // Tribunes
            ['type' => 'material', 'name' => 'simple_platform'], // Tribune simple
            ['type' => 'material', 'name' => 'sound_technician'], // Technicien sonorisation
            ['type' => 'material', 'name' => 'videoconference_technician'], // Technicien visioconférence
            ['type' => 'material', 'name' => 'translation_technician'], // Technicien visioconférence
            ['type' => 'material', 'name' => 'guardian'],

            // Eclairages
            ['type' => 'lighting', 'name' => 'natural'],
            ['type' => 'lighting', 'name' => 'artificial'],

            // Cocktail
            ['type' => 'cocktail', 'name' => 'cocktail'], // Si présent, alors cocktail de dispo dans la salle

            // Accès
            ['type' => 'access', 'name' => 'disabled'], // Accès handicapé
            // Types

            // Disposition
            ['type' => 'arrangement', 'name' => 'reunion'],
            ['type' => 'arrangement', 'name' => 'u'],
            ['type' => 'arrangement', 'name' => 'classe'],
            ['type' => 'arrangement', 'name' => 'theatre'],
            ['type' => 'arrangement', 'name' => 'cabaret'],
            ['type' => 'arrangement', 'name' => 'banquet'],
            ['type' => 'arrangement', 'name' => 'cocktail'],

        ]);
    }
}
