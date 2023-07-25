<?php

namespace App\Services;

use App\Models\Space;
use App\Models\SpaceGroup;
use Illuminate\Support\Facades\Cache;

class SpacesService
{

    public function getSpacesJson()
    {
        $spacesGroups = SpaceGroup::whereNotNull('lat')->whereNotNull('lon')->get();

        $address = [];

        foreach ($spacesGroups as $spaces) {
            if ($spaces->address == "") continue;

            $address[] = [
                'address' => $spaces->address . " " . $spaces->zip_code . " " . $spaces->city,
                'name' => $spaces->name,
                'highest_capacity' => $spaces->highest_capacity,
                'slug' => $spaces->slug,
                'highlight_image' => $spaces->highlight_image,
                'lat' => $spaces->lat,
                'lon' => $spaces->lon,
                'meta' => $spaces->meta
            ];
        }

        $addressJson = json_encode($address);
        return $address;
    }


    /**
     * return elements menus
     *
     * @return Array
     */
    public function getMenus(): Array {

        $key = 'homepage-space-menu';
        if (!Cache::has($key) || config('app.env') !== 'production')
        {
            $spaceMenus = SpaceGroup::whereNotNull('front_menu')
                ->select('slug', 'name')
                ->orderBy('front_menu', 'asc')
                ->pluck('slug', 'name')
                ->toArray();
            Cache::put($key, $spaceMenus);
        }
        $spaceMenus = Cache::get($key);

        return $spaceMenus;
    }


    public function getSpacesFormList() {

        $key = 'search-spaces-data';

        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $spaces = Space::with('spaceGroup')->get();
        $allSpaces    = [];
        $allCitys     = [];
        $allTags      = [];

        foreach($spaces as $space) {

            if(!$space->spaceGroup) continue;
            $allSpaces[$space->spaceGroup->name] = ['name' => $space->spaceGroup->name, 'slug' => $space->spaceGroup->slug];
            if($space->spaceGroup->city != "") {
                $city = trim($space->spaceGroup->city);
                $allCitys[$city] = $city;
            }
            $tagsList = [];
            foreach($space->tags as $tag) {
                if($tag->type == "type") {
                    $tags[$tag->name] = trans('forms.types.' . $tag->name);
                    $allTags[$tag->name]  = trans('forms.types.' . $tag->name);
                }
            }
            asort($tagsList);
            $allSpaces[$space->spaceGroup->name]['tags'] = $tags;

        }

        // list city
        ksort($allSpaces);
        // all citys
        asort($allCitys);
        // all tags
        asort($allTags);

        $search_spaces_data = [
            'allSpaces'    => $allSpaces,
            'allCitys'     => $allCitys,
            'allTags'      => $allTags,
        ];

        Cache::put($key, $search_spaces_data, 86400); // 24 hours
        return $search_spaces_data;
    }

}
