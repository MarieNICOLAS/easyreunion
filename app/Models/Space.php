<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Space extends Model implements Sitemapable
{
    use HasFactory, Sluggable;

    protected $fillable = ['name', 'space_group_id', 'capacity_min', 'capacity_max', 'area', 'meta', 'meta_title'];

    protected $with = ['tags'];

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder)
        {
            $builder->where('active', true);
        });

        self::addSlugOnCreated();

        static::created(function ($space)
        {
            Agenda::create([
                'space_id' => $space->id,
                'name' => 'Agenda de la salle ' . $space->name,
                'partner_id' => $space->spaceGroup->partner_id,
            ]);
        });

        static::deleting(function ($space)
        {
            $space->agenda->delete();
        });
    }

    public function scopeSearch($query, string $slug)
    {
        return $this->where('slug', 'LIKE', $slug);
    }

    /**
     * @param int $max
     * @param int|null $min
     * @param          $query
     *
     * @return mixed
     * @deprecated Remplacé par la fonction App\Models\SpaceGroup::scopeSearchCapacity.
     *
     */
    public function scopeSearchCapacity($query, int $max, int $min = null)
    {
        if (isset($min))
        {
            if ((bool)$min)
            {
                $query->where('capacity_min', '>=', $min);
            }
        }

        return $query->where('capacity_max', '<=', $min);
    }

    public function scopeSearchType($query, string $type)
    {
        return $query->whereHas('tags', function ($query) use ($type)
        {
            return $query->searchType($type);
        });
    }

    public function spaceGroup()
    {
        return $this->belongsTo(SpaceGroup::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, SpaceTag::class, 'space_id', 'tag_id')->withPivot('details');
    }

    public function media()
    {
        return $this->hasMany(Media::class)->orderBy('order', 'asc');
    }

    public function agenda()
    {
        return $this->hasOne(Agenda::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getCityAttribute()
    {
        return $this->spaceGroup->city;
    }

    public function offers()
    {
        return $this->spaceGroup->offers();
    }

    /**
     * @deprecated utiliser "$this->capacity_max" à la place
     */
    public function getCapacityAttribute()
    {
        return $this->capacity_max;
    }

    public function getHighlightImageAttribute()
    {
        return $this->media->first()?->url;
    }

    public function getThumbnailImagesAttribute()
    {
        $links = [];
        foreach ($this->media as $image)
            $links[] = $image->url;

        if (count($links) < 1)
            $links[] = asset('images/er-image-bg.jpg');

        return $links;
    }

    public function actions()
    {
        return $this->hasMany(SpaceAction::class);
    }

    public function getKeyAttribute()
    {
        return 'sp-' . $this->id;
    }

    public function toSitemapTag(): Url|string|array
    {
        return $this->full_url;
    }

    public function getFullUrlAttribute()
    {
        return route('space', [$this->sg_slug, $this]);
    }

    public function getParentFullUrlAttribute()
    {
        return route('spaceGroup', [$this->sg_slug]);
    }
}
