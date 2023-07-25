<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTagsTypeMaterial extends Migration
{
    public function up()
    {
        $tags = [
            'connected TV',
            'retractable screen',
            'handheld HF microphone',
            'micro pupite/ col cygne',
        ];

        DB::table('tags')
            ->whereIn('name', $tags)
            ->update(['type' => 'material']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
