<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\OfferElement;
use App\Models\SpaceGroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OffersController extends Controller
{
    public function index()
    {
        return view('partners.offer.index');
    }

    public function create()
    {
        return view('partners.offer.create');
    }

    public function edit(Offer $offer)
    {
        return view('partners.offer.edit', ['offer' => $offer]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:100',
            'description' => 'min:5|max:1000',
        ]);

        $offer = new Offer;
        $offer->name = $request->input('name');
        $offer->partner_id = $request->user()->selectedPartner()->id;

        $offer->description = $request->input('description');
        // for start/stop both need to be either set or empty at the same time
        if (($request->input('start') && $request->input('stop')) || (! $request->input('start') && ! $request->input('stop'))) {
            $offer->start = $request->input('start');
            $offer->stop = $request->input('stop');
        }

        if ($request->input('space_group_id')) {
            $sg = SpaceGroup::find($request->input('space_group_id'));
            $this->authorize('update', $sg);
            $offer->space_group_id = $sg->id;
        }

        if ($offer->save() && $request->input('space_group_id')) {
            return response()->redirectToRoute('partner.space-groups.show', $sg);
        }

        // TODO : Ajouter erreur de création lors de la redirection en arrière.
        return redirect()->route('partner.offer.index');
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'name' => 'required|min:2|max:100',
            'description' => 'min:5|max:1000',
        ]);
        $offer->name = $request->input('name');
        $offer->description = $request->input('description');
        // for start/stop both need to be either set or empty at the same time
        if (($request->input('start') && $request->input('stop')) || (! $request->input('start') && ! $request->input('stop'))) {
            $offer->start = $request->input('start');
            $offer->stop = $request->input('stop');
        }
        $offer->save();

        if ($offer->save()) {
            return redirect()->route('partner.offer.edit', $offer);
        }
    }

    public function delete(Request $request, Offer $offer)
    {
        if ($offer->delete()) {
            return response()->redirectToRoute('partner.offer.index');
        }
    }

    public function add_element(Request $request, Offer $offer)
    {
        $request->validate([
            'description' => 'required|min:2|max:200',
            'unit_type' => ['required', Rule::in(['prestation', 'heure', 'personne'])],
            'unit_price' => 'required|min:0',
            'tax_rate' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'optional' => '',
            'agenda' => 'required|exists:agendas,id',
        ]);

        // TODO validate agenda is yours or you're admin
        $elmt = new OfferElement;
        $elmt->agenda_id = $request->input('agenda');
        $elmt->description = $request->input('description');
        $elmt->unit_type = $request->input('unit_type');
        $elmt->tax_rate = $request->input('tax_rate');
        $elmt->unit_price = $request->input('unit_price');
        $elmt->optional = $request->has('optional');
        $elmt->offer_id = $offer->id;
        $elmt->partner_id = $request->user()->selectedPartner()->id;

        if ($elmt->save()) {
            return response()->redirectToRoute('partner.offer.edit', ['offer' => $offer]);
        }

        // TODO : Ajouter erreur de création lors de la redirection en arrière.
        return response()->back();
    }

    public function remove_element(Offer $offer, OfferElement $elmt)
    {
        if ($elmt->delete()) {
            return response()->redirectToRoute('partner.offer.edit', ['offer' => $offer]);
        }
    }
}
