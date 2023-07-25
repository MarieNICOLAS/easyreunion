<?php

namespace App\Http\Controllers\API;

use App\Mail\User\BookingConfirmedMail;
use App\Models\Agenda;
use App\Models\AgendaElement;
use App\Models\Booking;
use App\Models\Estimate;
use App\Models\Space;
use App\Notifications\BookingConfirmedNotification;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class AgendaController extends APIController
{
    public function loadAvailableSpaces(Request $request)
    {
        if ($request->user()->rank === 'admin')
            $spaces = Space::select('id', 'name', 'space_group_id', 'slug')->with('spaceGroup:id,name,city,zip_code', 'agenda:id,space_id')
                ->orderBy('space_group_id')
                ->get();
        else
        {
            $partners = $request->user()->partners->pluck('id');
            $spaces = Space::select('id', 'name', 'slug', 'space_group_id')->whereHas('spaceGroup', function ($r) use ($partners)
            {
                return $r->whereIn('partner_id', $partners);
            })
                ->with('spaceGroup:id,name,city,zip_code', 'agenda:id,space_id')
                ->orderBy('space_group_id')
                ->get();
        }

        return $this->success($spaces);
    }

    public function retrieve(Request $request)
    {

        $calendarDatas = $request->input('calendars');

        $request->validate(['start' => 'required', 'end' => 'required', 'calendars' => 'required']);
        $calendars = Agenda::whereIn('space_id', explode(',', $calendarDatas))->get();
        $start = Carbon::parse($request->get('start'))->locale('fr_FR');
        $end = Carbon::parse($request->get('end'));

        $return = [];
        $return['agendas'] = [];
        foreach ($calendars as $calendar)
        {

            $this->authorize('show', $calendar);
            $return['agendas'][$calendar->id] = $calendar->computeElements($start->copy(), $end->copy(), $request->user()->rank === 'admin');

            if ($request->user()->rank !== 'admin')
                $return['agendas'][$calendar->id] = $this->removeRequests($return['agendas'][$calendar->id]);
        }

        // Generating header
        $return['header'] = [];
        $numDays = $start->diffInDays($end);
        for ($i = 0; $i <= $numDays; $i++)
        {
            $return['header'][] = [
                'month' => $start->monthName,
                'day' => substr($start->dayName, 0, 3),
                'num' => $start->day
            ];
            $start->addDay();
        }

        return $this->success($return);
    }

    private function removeRequests($elements)
    {

        foreach ($elements as $index => $date)
        {
            foreach ($date as $index2 => $period)
            {
                if ($period['status'] == 'option_request')
                    unset($elements[$index][$index2]);
            }
        }
        return $elements;
    }

    public function addElement(Request $request)
    {
        $request->validate([
            'agenda_id' => 'required',
            'start' => 'required',
            'end' => 'required',
            'name' => 'required'
        ]);

        $el = new AgendaElement();
        $el->agenda_id = $request->input('agenda_id');
        $el->start = $request->input('start');
        $el->end = $request->input('end');
        $el->name = $request->input('name');
        $el->setCreatedAt(date('Y-m-d H:i:s'));

        $user = Auth::user();
        $el->created_by = $user->getNameAttribute();
        $el->updated_by = $user->getNameAttribute();

        if ($request->input('booking_id'))
        {
            $el->status = Booking::select('id', 'status')->find($request->input('booking_id'))->status;
            $el->booking_id = $request->input('booking_id');
            $el->estimate_id = $request->input('estimate_id');
        } else if ($request->input('estimate_id'))
        {
            $el->status = Estimate::select('id', 'status')->find($request->input('estimate_id'))->status;
            $el->estimate_id = $request->input('estimate_id');
        } else if ($request->input('type') &&
            (in_array($request->input('type'), ['partner_option', 'partner_confirmation'])
                || ($request->input('type') == 'option') && $request->user()->rank === 'admin'))
        {
            $el->status = $request->input('type');
        } else abort(403);

        $el->save();

        // Refresh booking models
        if ($el->booking)
        {
            $el->booking->refreshBookingDates();
        }
        if ($el->estimate)
        {
            $el->estimate->refreshBookingDate();
        }

        $el->append('space');

        Agenda::find($request->input('agenda_id'))->flushCache();
        return $this->success($el);
    }

    public function removeElement(Request $request, AgendaElement $element)
    {
        $this->authorize('delete', $element);

        $booking = $element->booking;
        $estimate = $element->estimate;
        $agenda = $element->agenda;
        $element->delete();
        $agenda->flushCache();
        // Refresh booking models
        if ($booking)
        {
            $booking->refreshBookingDates();
        }
        if ($estimate)
        {
            $estimate->refreshBookingDate();
        }

        return $this->success([]);
    }

    public function getAgendaElement(Request $request, AgendaElement $element)
    {
        $this->authorize('update', $element);


        if ($request->user()->isAdmin)
            $availableSpaces = Space::select('id', 'name')->with('agenda:id')->get();
        else
        {
            $partners = $request->user()->partners->pluck('id');
            $availableSpaces = Space::select('id', 'name')->whereHas('spaceGroup', function ($r) use ($partners)
            {
                return $r->whereIn('partner_id', $partners);
            })->with('agenda:id')->get();
        }

        return $this->success([
            'element' => $element,
            'availableSpaces' => $availableSpaces
        ]);
    }

    public function getElementsForDate(Request $request, Agenda $agenda, $date)
    {
        $date = Carbon::parse($date)->locale('fr_FR');
        $elements = $agenda->elementsForDay($date)->append(['has_conflicts', 'cancellation_reason']);

        if ($request->user()->rank !== 'admin')
        {
            $elements = $this->removeRequests([$elements]);
            if (count($elements) > 0)
                $elements = $elements[0];
        }

        // Adding referents and spaces
        foreach ($elements as $element)
        {
            if ($element->booking_id)
            {
                $element->referent = $element->booking->referent;
            } else if ($element->estimate_id)
            {
                $element->referent = $element->estimate->referent;
            }
        }


        return $this->success(['elements' => $elements, 'date' => $date->format('d/m/Y'), 'space_id' => $agenda->space_id,
            'available_spaces' => Space::select('id', 'name')->with('agenda:id,space_id')->where('space_group_id', $agenda->space->space_group_id)->get()]);
    }

    public function updateElement(Request $request, AgendaElement $element)
    {
        $this->authorize('update', $element);

        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
            'status' => 'required',
            'name' => 'required',
            'agenda_id' => 'required|exists:agendas,id'
        ]);

        // Updating main settings
        $element->start = $request->input('start');
        $element->end = $request->input('end');
        $element->name = $request->input('name');

        // Updating status if authorized
        if ($request->user()->rank !== 'admin' && !in_array($request->input('status'), ['partner_option', 'partner_confirmation']))
            abort(403);

        $element = $this->updateAgendaElementStatus($element, $request->input('status'));

        if ($element->booking && $request->input('status') === "cancelled" && $request->input('cancellation_reason'))
        {
            $booking = $element->booking;
            $booking->cancellation_reason = $request->input('cancellation_reason');
            $booking->save();
        }

        // Updating agenda_id if authorized
        if ($request->user()->rank !== 'admin')
            $this->authorize('update', Agenda::find($request->input('agenda_id')));
        $element->agenda_id = $request->input('agenda_id');

        $element->save();

        // If booking, update dates
        if ($element->booking)
        {
            $element->booking->refreshBookingDates();
        }

        // flushing then reloading element because agenda might have changed
        $element->agenda->flushCache();
        $element = $element->fresh();
        $element->agenda->flushCache();

        return redirect()->back()->with(['success' => 'Élément mis à jour']);

    }

    private function updateAgendaElementStatus(AgendaElement $element, $newStatus)
    {
        $oldStatus = $element->status;

        // If we have an option with an estimate with no booking yet, create the associated booking
        if ($oldStatus === 'option' && $newStatus === 'confirmation' && $element->estimate_id && !$element->booking_id)
        {
            $element->estimate->createBooking();
        } else if ($element->booking_id && !$element->booking)
        {
            Bugsnag::notifyError('ERREUR avec un élément', "Avec l'id : " . $element->id);
        } else if ($oldStatus === 'option' && $newStatus === 'confirmation' && $element->booking)
        {
            // Notify partners
            foreach ($element->booking->partners as $partner)
            {
                $partner->notify(new BookingConfirmedNotification($element->booking));
            }

            // Notify user that booked
            Mail::to($element->booking->user)->send(new BookingConfirmedMail($element->booking));

        } else if ($oldStatus === 'option_request' && $newStatus === 'option' && !$element->estimate && $element->request)
        {
            app(\App\Http\Controllers\Admin\EstimateRequestController::class)->createEstimate($element->request);
        }

        // If there is a booking, update it's status
        if ($element->booking)
        {
            $booking = $element->booking;
            $booking->status = $newStatus;
            $booking->save();

            if (in_array($oldStatus, ['confirmation', 'option']) && $newStatus === 'cancelled')
            {
                $element->booking->cancel();
            }
        }


        $element->status = $newStatus;


        return $element;
    }

}
