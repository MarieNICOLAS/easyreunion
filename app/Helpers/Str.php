<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str as OriginalStr;

class Str extends OriginalStr
{
    /**
     * From a table and a name, generates an unique slug
     */
    public static function uniqueSlug(string $table, string $name)
    {
        $cursor = 0;
        while (true) {
            $slug = self::slug($name);
            if (0 < $cursor) {
                $slug .= "-$cursor";
            }
            $all_slugs = DB::table($table)->select('id')->where('slug', $slug)->count();
            if (1 < $all_slugs) {
                $cursor++;
            } else {
                return $slug;
            }
        }
    }

}
