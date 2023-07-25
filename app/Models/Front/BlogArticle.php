<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;


class BlogArticle extends Model implements Sitemapable
{

    use HasFactory;

    protected $primaryKey = 'id';


    public function getPublicatedAt() {

        $date = new \DateTime($this->publicated_at);
        return $date;
    }

    /**
     * Get the Category that owns the Article
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }


    /**
     * Get all elements
     */
    public function elements()
    {
        return $this->hasMany(BlogArticleElement::class, 'article_id');
    }

    public function toSitemapTag(): Url | string | array
    {
        return route('articles.show', $this->slug);
    }

}
