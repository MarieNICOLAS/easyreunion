<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogArticleElement extends Model
{

    use HasFactory;

    /**
     * Get the Article
     */
    public function article()
    {
        return $this->belongsTo(BlogArticle::class, 'article_id');
    }


    /**
     * Get the Article
     */
    public function type()
    {
        return $this->belongsTo(BlogElementType::class, 'type_id');
    }


}
