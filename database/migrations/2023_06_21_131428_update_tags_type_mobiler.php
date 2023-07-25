<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTagsTypeMobiler extends Migration
{
    public function up()
    {
        $tags = [
            'chairs',
            'armchairs',
            'tables',
            'platform',
            'catering round table',
            'catering buffet',
            'eat standing up',
            'fireside chair',
            'layer',
            'view breeze',
        ];

        DB::table('tags')
            ->whereIn('name', $tags)
            ->update(['type' => 'mobilier']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
