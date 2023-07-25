<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('space_groups')->update(['status' => 'online']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('space_groups', function (Blueprint $table) {
            //
        });
    }
};
