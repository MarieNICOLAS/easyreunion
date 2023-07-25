<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;


class Page extends Model implements Sitemapable
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function toSitemapTag(): Url | string | array
    {
        return route('page.show', $this);
    }
}
