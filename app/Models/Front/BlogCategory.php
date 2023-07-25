<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    public $timestamps = false;


    use HasFactory;

    /**
     * Get the articles for the category
     */
    public function articles()
    {
        return $this->hasMany(BlogArticle::class);
    }

}
