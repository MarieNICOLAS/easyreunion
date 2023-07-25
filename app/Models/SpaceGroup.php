<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use App\Models\Scopes\OnlineScope;


class SpaceGroup extends Model implements Sitemapable
{
    use HasFactory, Sluggable;

    protected $fillable = ['name', 'city', 'slug', 'access', 'address', 'zip_code', 'space_group_id', 'meta', 'meta_title', 'status'];

    protected $appends = ['lowest_capacity', 'highest_capacity', 'highlight_image', 'area'];

    protected static function booted()
    {
        static::addGlobalScope(new OnlineScope);
    }

    public static function withoutOnlineScope()
    {
        return (new static)->newQueryWithoutScope(new OnlineScope);
    }

    public function scopeSearch($query, string $slug)
    {
        return $this->where('slug', 'LIKE', strtolower($slug));
    }

    public function scopeSearchCity($query, string $city)
    {
        return $query->where('city', 'LIKE', strtolower($city));
    }

    public function scopeSearchCapacity($query, int $capacity)
    {
        return $query->whereHas('spaces', function ($query) use ($capacity)
        {
            $query->where('capacity_min', '<=', $capacity)->where('capacity_max', '>=', $capacity);
        });
    }

    public function scopeSelectCitiesByPriority($query)
    {
        return $query->selectRaw('city, COUNT(id) as priority')->groupBy('city')->orderBy('priority', 'DESC');
    }

    public function scopeSearchTypeAndCity($query, string $type, string $city)
    {
        $result = DB::select(<<<SQL
            SELECT DISTINCT `id`
            FROM `spaces`
            WHERE `id` IN (
              SELECT `space_id`
              FROM `space_tag`
              WHERE `tag_id` IN (
                SELECT `id`
                FROM `tags`
                WHERE `type` = "type"
                  AND `name` LIKE "$type"
              ) AND `space_group_id` IN (
                  SELECT `id`
                  FROM `space_groups`
                  WHERE `city` LIKE "$city"
              )
            )
        SQL
        );

        return array_map(fn($e) => Space::with('media')->find($e->id), $result);
    }

    public function spaces()
    {
        return $this->hasMany(Space::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function getLowestCapacityAttribute()
    {
        if ($this->spaces->count() < 1)
        {
            return null;
        }

        return $this->spaces->sortBy('capacity_min')->first()->capacity_min;
    }

    public function getHighestCapacityAttribute()
    {
        if ($this->spaces->count() < 1)
        {
            return null;
        }

        return $this->spaces->sortByDesc('capacity_max')->first()->capacity_max;
    }

    public static function getAvailableCities()
    {
        return self::select('city')->orderBy('city')->distinct()->get()->pluck('city')->toArray();
    }

    public function media()
    {
        return $this->hasMany(Media::class)->orderBy('order');
    }

    public function getHighlightImageAttribute()
    {
        return $this->media->first()?->url;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getAreaAttribute()
    {
        return $this->spaces->sum('area');
    }

    public function getCapacityAttribute()
    {
        return $this->spaces->sum('capacity_max');
    }

    public function getHasDisabledAccessAttribute()
    {
        return $this->spaces->where('has_disabled_access', false)->count() < 1;
    }

    public function getThumbnailImagesAttribute()
    {
        return $this->media->pluck('url');
    }

    public function getKeyAttribute()
    {
        return 'sg-' . $this->id;
    }

    public function toSitemapTag(): Url|string|array
    {
        return route('spaceGroup', $this);
    }
}
