<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\User;
use App\Notifications\Admin\PartnerRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class OnboardingController extends Controller
{
    public function start(Request $request, $type)
    {
        if (! in_array($type, ['annuaire', 'gestion'])) {
            abort(403);
        }

        return view('partners.onboarding.index');
    }

    public function store(Request $request, $type)
    {
        if (! in_array($type, ['annuaire', 'gestion'])) {
            abort(403);
        }

        $request->validate([
            'type' => ['required', Rule::in(['traiteur', 'dj', 'agent', 'spaceowner'])],
            'company' => 'nullable',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            // 'website' => '',
        ]);

        $partner = Partner::create([
            'type' => $request->input('type'),
            'name' => $request->input('name'),
            'company' => $request->input('company'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'website' => $request->input('website'),
        ]);

        $partner->users()->attach($request->user());

        Notification::send(User::getAdmins(), new PartnerRequestNotification($partner));

        return redirect()->back()->with('success', 'Votre demande pour devenir partenaire a été effectuée');
    }
}
