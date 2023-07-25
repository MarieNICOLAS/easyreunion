<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\AgendaElement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        return view('partners.agenda.index');
    }

    public function getElementsForDate(Request $request, Agenda $agenda, $date)
    {
        return view('partners.calendar.elements-for-day')->with(['agendaId' => $agenda->id, 'date' => $date]);
    }

    public function confirmUpToDate(Agenda $agenda)
    {
        $this->authorize('update', $agenda);

        $agenda->last_verified_at = Carbon::now();
        $agenda->save();

        return redirect()->back();
    }

    public function deleteElement(Request $request, AgendaElement $element)
    {
        app(\App\Http\Controllers\API\AgendaController::class)->removeElement($request, $element);

        return redirect()->back()->with(['success' => 'Élément supprimé']);
    }

}
