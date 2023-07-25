<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\API\APIController;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;

class PartnerController extends APIController
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $partner = Partner::create([
            'type' => 'spaceowner',
            'company' => $request->input('name'),
            'email' => $request->input('email'),
            'is_validated' => 1
        ]);

        return $this->success(['url' => route('admin.partners.show', $partner)]);
    }

    public function addUser(Request $request, Partner $partner, User $user)
    {

    }
}
