<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['key', 'value'];

    public static function getThumbnailInfo($key)
    {
        $type = substr($key, 0, 2);
        $id = substr($key, 3);

        $data = [];
        $data['key'] = $key;

        if ($type === 'sg')
        {
            $sg = SpaceGroup::with('spaces:id,capacity_min,capacity_max,space_group_id', 'spaces.media', 'media')->find($id);

            $data['name'] = $sg->name;
            $data['slug'] = $sg->slug;
            $data['zip'] = $sg->zip_code;
            $data['city'] = $sg->city;
            $data['sg_slug'] = '';
            $data['low_capacity'] = $sg->lowestCapacity;
            $data['max_capacity'] = $sg->highestCapacity;
            $data['has_disabled_access'] = $sg->has_disabled_access;
            $data['thumbnail_images'] = $sg->thumbnail_images;
            $data['area'] = $sg->area;
            $data['type'] = 'sg';
        } else
        {
            $sp = Space::with('media', 'spaceGroup')->find($id);
            $data['name'] = $sp->name;
            $data['slug'] = $sp->slug;
            $data['city'] = $sp->city;
            $data['sg_slug'] = $sp->sg_slug;
            $data['zip'] = $sp->spaceGroup->zip_code;
            $data['low_capacity'] = $sp->capacity_min;
            $data['max_capacity'] = $sp->capacity_max;
            $data['has_disabled_access'] = $sp->has_disabled_access;
            $data['thumbnail_images'] = $sp->thumbnail_images;
            $data['area'] = $sp->area;
            $data['type'] = 'sp';
        }

        return $data;
    }

    public static function getHomePageSettings()
    {
        $data = [];
        $settings = self::whereIn('key', ['hp_featured_space_1', 'hp_featured_space_2', 'hp_featured_space_3', 'hp_featured_space_4', 'hp_featured_space_5', 'hp_featured_space_6', 'hp_featured_space_7', 'hp_featured_space_8', 'hp_featured_space_9', 'hp_exclusive_space_1', 'hp_exclusive_space_2', 'hp_exclusive_space_3', 'hp_exclusive_space_4', 'hp_exclusive_space_5', 'hp_exclusive_space_6'])->get();

        $data['featured'] = [];
        $data['featured'][] = self::getThumbnailInfo($settings->where('key', 'hp_featured_space_1')->first()->value);
        $data['featured'][] = self::getThumbnailInfo($settings->where('key', 'hp_featured_space_2')->first()->value);
        $data['featured'][] = self::getThumbnailInfo($settings->where('key', 'hp_featured_space_3')->first()->value);
        $data['featured'][] = self::getThumbnailInfo($settings->where('key', 'hp_featured_space_4')->first()->value);
        $data['featured'][] = self::getThumbnailInfo($settings->where('key', 'hp_featured_space_5')->first()->value);
        $data['featured'][] = self::getThumbnailInfo($settings->where('key', 'hp_featured_space_6')->first()->value);
        $data['featured'][] = self::getThumbnailInfo($settings->where('key', 'hp_featured_space_7')->first()->value);
        $data['featured'][] = self::getThumbnailInfo($settings->where('key', 'hp_featured_space_8')->first()->value);
        $data['featured'][] = self::getThumbnailInfo($settings->where('key', 'hp_featured_space_9')->first()->value);

        $data['exclusive'] = [];
        $data['exclusive'][] = self::getThumbnailInfo($settings->where('key', 'hp_exclusive_space_1')->first()->value);
        $data['exclusive'][] = self::getThumbnailInfo($settings->where('key', 'hp_exclusive_space_2')->first()->value);
        $data['exclusive'][] = self::getThumbnailInfo($settings->where('key', 'hp_exclusive_space_3')->first()->value);
        $data['exclusive'][] = self::getThumbnailInfo($settings->where('key', 'hp_exclusive_space_4')->first()->value);
        $data['exclusive'][] = self::getThumbnailInfo($settings->where('key', 'hp_exclusive_space_5')->first()->value);
        $data['exclusive'][] = self::getThumbnailInfo($settings->where('key', 'hp_exclusive_space_6')->first()->value);
        return $data;
    }

}
