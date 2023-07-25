<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PartnerAccountController extends Controller
{
    public function getSettings()
    {
        return view('partners.settings');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'company' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'website' => 'required',
            'iban' => 'required',
        ]);

        $partner = $request->user()->selectedPartner();
        $partner->company = $request->input('company');
        $partner->email = $request->input('email');
        $partner->phone = $request->input('phone');
        $partner->website = $request->input('website');
        $partner->iban = $request->input('iban');
        $partner->save();

        return redirect()->back();
    }
}
