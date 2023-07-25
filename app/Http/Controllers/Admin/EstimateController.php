<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estimate;
use App\Models\User;
use App\Services\SellsyService;
use Illuminate\Http\Request;

class EstimateController extends Controller
{
    public function index()
    {
        return view('admin.estimates.index');
    }

    public function searchUser(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->with('organization:id,name')->first();

        // Checking Sellsy
        if (!$user)
        {
            $sellsy = new SellsyService();
            $id = $sellsy->searchContactSellsy($email);
            if ($id)
            {
                $sellsyUser = $sellsy->retrieveContact($id);
                $user = $sellsy->importUserFromSellsy($sellsyUser);
            }
        }

        return response()->json($user);

    }

    public function store(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);
        $user = User::find($request->input('user_id'));
        return Estimate::create(['user_id' => $user->id,
            'status' => "option",
            'organization_id' => $user->organization_id,
            'er_referent_id' => $request->user()->id
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.estimates.choose-customer');
    }

    public function edit(Request $request, Estimate $estimate)
    {
        return view('admin.estimates.edit')->with('estimate', $estimate);
    }
}
