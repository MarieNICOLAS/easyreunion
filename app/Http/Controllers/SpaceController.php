<?php

namespace App\Http\Controllers;

use App\Models\
{Space, SpaceGroup};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class SpaceController extends Controller
{


    public function show(Request $request, $sg, $space)
    {
        $space = Space::where(['slug' => $space, 'sg_slug' => $sg])->firstOrFail();

        // This redirects url that don't have the same case to the real one. for example esPace-chaptal to espace-chaptal
        if (url()->current() !== route('space', ['sg' => $space->sg_slug, 'space' => $space]))
            return redirect(route('space', ['sg' => $space->sg_slug, 'space' => $space]));

        $space_tags = $space->tags;
        $allTags = $space_tags->groupBy('type');

        $tags = [];
        $materials = [];
        $types = [];
        $arrangementTags = [];
        $servicesTags = [];
        $mobilierTags = [];

        foreach ($space_tags as $tag)
        {
            if ('arrangement' === $tag->type)
            {
                $tags[$tag->name] = json_decode($tag->pivot->details)->capacity ?? null;
                $arrangementTags[$tag->name] = json_decode($tag->pivot->details)->capacity ?? null;
            }
            if ('material' === $tag->type)
            {
                $materials[] = $tag->name;
            }
            if ('type' === $tag->type)
            {
                $types[] = $tag->name;
            }
            if ('services' === $tag->type)
            {
                $servicesTags[] = $tag->name;
            }
            if ('mobilier' === $tag->type)
            {
                $mobilierTags[] = $tag->name;
            }
        }
        $allTags = $space_tags->groupBy('type');


        return view('guest.space')->with(compact('space', 'tags', 'materials', 'types', 'arrangementTags', 'servicesTags', 'mobilierTags', 'allTags'));

    }

    public function showGroup(Request $request, SpaceGroup $sg)
    {
        // This redirects url that don't have the same case to the real one. for example esPace-chaptal to espace-chaptal
        if (url()->current() !== route('spaceGroup', $sg))
            return redirect(route('spaceGroup', $sg));

        return view('guest.space')->with('space', $sg);
    }

    public function list(Request $request)
    {
        $key = 'spaces-data';
        if (!Cache::has($key))
        {
            $spaces = Space::with('spaceGroup')->get();

            foreach ($spaces as $space)
            {
                if(!$space->spaceGroup) continue;

                $spacesArray[$space->spaceGroup->name][] = $space;
                if ($space->spaceGroup->city != "")
                {
                    $city = trim($space->spaceGroup->city);
                    $spacesCity[$city] = $city;
                }
                $spaceGroups[$space->spaceGroup->name] = $space->spaceGroup->name;

                foreach ($space->tags as $tag)
                {
                    if ($tag->type == "type")
                    {
                        $spacesTag[$tag->name] = trans('forms.types.' . $tag->name);
                    }
                }
            }

            ksort($spacesArray);
            ksort($spaceGroups);
            ksort($spacesCity);
            asort($spacesTag);

            $p = 1;
            $i = 0;

            foreach ($spacesArray as $groups)
            {
                foreach ($groups as $space)
                {

                    $arr[$p][] = $space;
                    $i++;
                    if ($i == 9)
                    {
                        $p++;
                        $i = 0;
                    }
                }
            }

            $spaces_data = [
                'spaces' => $arr,
                'nbPage' => $p,
                'spaceGroups' => $spaceGroups,
                'citys' => $spacesCity,
                'types' => $spacesTag,
            ];

            Cache::put($key, $spaces_data, 21600); // 6 hours
        } else
        {
            $spaces_data = Cache::get($key);
        }


        return view('guest.catalogue',
            $spaces_data);

    }

}
