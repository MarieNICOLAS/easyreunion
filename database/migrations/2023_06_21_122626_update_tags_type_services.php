<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTagsTypeServices extends Migration
{
    public function up()
    {
        $tags = [
            'cloakrooms',
            'hostesses',
            'sound_technician',
            'translation_technician',
            'guardian',
            'reception breakfast',
            'coffee/tea break',
            'caterer',
            'videoconference_technician',
            'stage manager',
        ];

        DB::table('tags')
            ->whereIn('name', $tags)
            ->update(['type' => 'services']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
