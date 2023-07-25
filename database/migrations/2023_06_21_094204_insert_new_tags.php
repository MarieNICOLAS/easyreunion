<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertNewTags extends Migration
{
    public function up()
    {
        $tags = [
            'retractable screen',
            'connected TV',
            'handheld HF microphone',
            'micro pupite/ col cygne',
            'catering round table',
            'catering buffet',
            'eat standing up',
            'fireside chair',
            'layer',
            'view breeze',
            'reception breakfast',
            'coffee/tea break',
            'caterer',
            'stage manager',
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'name' => $tag,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};