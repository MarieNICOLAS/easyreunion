<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Space;
use App\Models\SpaceGroup;
use App\Models\Tag;
use Illuminate\Http\Request;

class SpacesController extends Controller
{
    public function __construct()
    {
        $this->middleware('partner_type:spaceowner');
    }

    public function create(SpaceGroup $space_group)
    {
        return view('partners.space-groups.space.create', ['space_group' => $space_group]);
    }


    public function show(SpaceGroup $space_group, Space $space)
    {
        return view('partners.space-groups.space.show', ['space_group' => $space_group, 'space' => $space]);
    }

    public function edit(SpaceGroup $space_group, Space $space)
    {
        return view('partners.space-groups.space.edit', ['space_group' => $space_group, 'space' => $space]);
    }

    public function store(Request $request, SpaceGroup $space_group)
    {
        $request->validate([
            'name' => 'required|min:2|max:100',
            'capacity_max' => 'required|min:1',
            'area' => 'min:1',
        ]);

        $space = new Space;
        $space->name = $request->input('name');
        $space->capacity_max = $request->input('capacity_max');
        $space->area = $request->input('area');
        $space->space_group_id = $space_group->id;
        $space->sg_slug = $space->spaceGroup->slug;

        $space->save();

        return response()->redirectToRoute('partner.space-groups.show', $space_group);

        // TODO : Ajouter erreur de création lors de la redirection en arrière.
    }

    public function update(Request $request, Space $space)
    {
        $request->validate([
            'name' => 'required|min:2|max:100',
            'capacity_max' => 'required|min:1',
            'area' => 'min:1',
        ]);

        $space->name = $request->input('name');
        $space->capacity_max = $request->input('capacity_max');
        $space->area = $request->input('area');
        if ($space->save())
        {
            return response()->redirectToRoute('partner.spaces.show', $space);
        }
    }

    public function delete(Request $request, Space $space)
    {
        if ($space->delete())
        {
            return response()->redirectToRoute('partner.space-groups.show', $space->spaceGroup);
        }
    }

    public function updateDescription(Request $request, Space $space)
    {
        $request->validate(['presentation' => 'required']);

        $this->authorize('update', $space->spaceGroup);
        $space->meta = $request->input('meta');
        $space->meta_title = $request->input('meta_title');
        $space->presentation = $request->input('presentation');
        $space->save();

        return redirect()->back();
    }

    public function updateTags(Request $request, Space $space)
    {
        $this->authorize('update', $space->spaceGroup);

        $materialsTags = $request->input('materials') ?? [];
        $mobilierTags = $request->input('mobilier') ?? [];
        $servicesTags = $request->input('services') ?? [];
        $arrangementTags = $request->input('arrangement') ?? [];

        $tags = array_merge(array_keys($materialsTags), array_keys($mobilierTags), array_keys($servicesTags), array_keys($arrangementTags), array_keys($request->input('access') ?? []));

        $space->tags()->sync($tags);
        $space->save();

        foreach ($request->input('num') as $arrangementTagId => $capacity) {
            $space->tags()->updateExistingPivot($arrangementTagId, ['details' => json_encode(['capacity' => $capacity])]);
        }

        $tag = Tag::where('name', 'disabled_access')->first();

        $space->has_disabled_access = $request->input('access') && array_key_exists($tag->id, $request->input('access')) && $request->input('access')[$tag->id] === 'on';
        $space->save();

        return redirect()->back();
    }


}
