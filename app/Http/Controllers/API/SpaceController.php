<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Space;
use App\Models\SpaceGroup;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SpaceController extends Controller
{
    public function search(Request $request)
    {
        $result = Space::select('id', 'name')->where('name', 'like', '%' . $request->input('query') . '%');

        if ($request->user()->rank !== 'admin') {
            $sgs = $request->user()->selectedPartner()->spaceGroups()->select('id')->get()->pluck('id');
            $result = $result->whereIn('space_group_id', $sgs);
        }

        return response()->json($result->get());
    }


    public function fastSearch(Request $request)
    {
        $queryString = $request->queryString;
        $spacesGroup = SpaceGroup::where('name', 'like', '%' . $queryString . '%')->orderBy('name')->get();
        return response()->json($spacesGroup);
    }

    // Returns catalogue. Can take numGuests and city as query parameters
    public function getSpaces(Request $request)
    {
        $res = Space::select('id', 'name', 'capacity_min', 'capacity_max', 'slug', 'sg_slug', 'space_group_id', 'area', 'has_disabled_access')
            ->with('media', 'spaceGroup:id,name');
        if ($request->input('numGuests')) {
            $numGuests = (int)$request->input('numGuests');
            $res = $res->where('capacity_max', '>=', $numGuests)->where('capacity_min', '<=', $numGuests);
        }
        if ($request->input('city')) {
            $city = $request->input('city');
            $res = $res->whereHas('spaceGroup', function ($query) use ($city) {
                $query->where('city', $city);
            });
        }
        if ($request->input('type')) {
            $type = $request->input('type');
            $res = $res->whereHas('tags', function ($query) use ($type) {
                $query->where('name', $type);
            });

        }

        $data = $res->paginate(9);

        $data->each(function ($space) {
            $space->append('thumbnail_images', 'full_url', 'parent_full_url');
        });

        return response()->json($data);
    }

    public function getCitiesAndTags()
    {
        $availableCitiesAndTags = Cache::get('available-cities-and-tags');
        if (!$availableCitiesAndTags) {
            $availableCities = SpaceGroup::select('city')->where('city', '!=', '')->distinct()->get()->pluck('city');
            $availableTags = Tag::select('name')->where('type', 'type')->get()->pluck('name');
            $availableCitiesAndTags = [
                'cities' => $availableCities,
                'tags' => $availableTags
            ];
            Cache::put('available-cities-and-tags', $availableCitiesAndTags, 10);
        }

        return response()->json($availableCitiesAndTags);
    }
}
