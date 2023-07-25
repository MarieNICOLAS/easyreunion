<?php

use App\Models\Space;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tag = Tag::create([
            'name' => "disabled_access",
            'type' => "access"
        ]);

        foreach (Space::where('has_disabled_access', true)->get() as $space)
        {
            $space->tags()->attach($tag->id);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
