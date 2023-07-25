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
        Schema::table('space_groups', function (Blueprint $table) {
            DB::statement("UPDATE space_groups SET status = 'online' WHERE status IS NULL OR status = '';");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('space_groups', function (Blueprint $table) {

        });
    }
};
