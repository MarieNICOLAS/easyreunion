<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Scopes\OnlineScope;
use App\Models\SpaceGroup;
use Illuminate\Http\Request;

class SpaceGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('partner_type:spaceowner');
    }

    public function index(Request $request)
    {
        $spacegroups = $request->user()->is_admin
            ? SpaceGroup::withoutGlobalScope(OnlineScope::class)->orderBy('name')->paginate(10)
            : $request->user()->selectedPartner()->spaceGroups()->withoutGlobalScope(OnlineScope::class)->orderBy('name')->paginate(10);

        return view('partners.space-groups.index')->with('spacegroups', $spacegroups);
    }

    public function create()
    {
        return view('partners.space-groups.create');
    }

    public function edit($slug)
    {
        $space_group = SpaceGroup::withoutGlobalScopes()->where('slug', $slug)->firstOrFail();

        $this->authorize('update', $space_group);
        $partners = Partner::whereNull('deleted_at')
            ->orderBy('company', 'asc')
            ->get();
        return view('partners.space-groups.show', ['space_group' => $space_group, "partners" => $partners]);
    }

    public function store(Request $request)
    {

        $space_group = new SpaceGroup;
        $space_group->name = $request->input('name');
        $space_group->address = $request->input('address');
        $space_group->city = $request->input('city');
        $space_group->zip_code = $request->input('zip_code');
        $space_group->partner_id = $request->user()->selectedPartner()->id;

        if ($space_group->save())
        {
            return response()->redirectToRoute('partner.space-groups.show', $space_group);
        }

        // TODO : Ajouter erreur de création lors de la redirection en arrière.
        return response()->back();

    }

    public function update(Request $request, $slug)
    {

        $space_group = SpaceGroup::withoutGlobalScopes()->where('slug', $slug)->firstOrFail();

        $file = $request->file('brochure');
        if ($file) {
            $destinationPath = 'storage/media/pdf';
            $fileName = $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $fileUrl = $destinationPath . '/' . $fileName;

            $space_group->brochure = $fileUrl;
            $space_group->brochure_name = $fileName;
        }

        $space_group->name = $request->input('name');
        $space_group->address = $request->input('address');
        $space_group->city = $request->input('city');
        $space_group->zip_code = $request->input('zip_code');
        $space_group->meta = $request->input('meta');
        $space_group->meta_title = $request->input('meta_title');

        $space_group->lat = $request->input('lat');
        $space_group->lon = $request->input('lon');

        if($request->input('slug')) {
            $space_group->slug = $request->input('slug');
        }

        if($request->input('partner_id')) {
            $space_group->partner_id = $request->input('partner_id');
        }

        if($request->input('status')) {
            $space_group->status = $request->input('status');
        }


        if ($space_group->save())
        {
            return response()->redirectToRoute('partner.space-groups.show', $space_group);
        }
    }

    public function updateDescription(Request $request, SpaceGroup $spaceGroup)
    {
        $request->validate(['presentation' => 'required']);

        $this->authorize('update', $spaceGroup);
        $spaceGroup->presentation = $request->input('presentation');
        $spaceGroup->save();

        return redirect()->back();
    }

    public function delete(Request $request, SpaceGroup $space_group)
    {
        if ($space_group->delete())
        {
            return response()->redirectToRoute('partner.space-groups.index');
        }
    }


    public function frontMenu() {
        $spaceGroups = SpaceGroup::where('front_menu', '<>', null)->orderBy('front_menu')->get();
        return view('partners.space-groups.frontMenu', ['spaceGroups' => $spaceGroups]);
    }

    public function updateOrderFrontMenu(Request $request) {

        $association = $request->association;
        $el = explode('-', $association);
        $id = $el[0]; $order = $el[1];


        $spaceGroup = SpaceGroup::find($id);

        $spaceGroup->front_menu = $order;
        $spaceGroup->save();

        return response()->json([$association]);

    }
}
