<?php

namespace App\Http\Controllers\API;

use App\Models\Agenda;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends APIController
{
    public function index(Request $request)
    {
        $bookingsQuery = Booking::select('id', 'amount_total', 'starts_at', 'user_id', 'status', 'organization_id', 'er_referent_id')
            ->with('user:id,first_name,last_name', 'organization:id,name', 'referent');

        if ($request->input('start') && $request->input('end'))
        {
            $bookingsQuery = $bookingsQuery->whereDate('starts_at', '>=', $request->input('start'))
                ->whereDate('starts_at', '<=', $request->input('end'));
        }

        if ($request->input('referent'))
        {
            $bookingsQuery = $bookingsQuery->where('er_referent_id', $request->input('referent'));
        }

        if ($request->input('spaces'))
        {
            $spaces = explode(',', $request->input('spaces'));
            $bookingsQuery = $bookingsQuery->whereHas('agendaElements', function ($q) use ($spaces)
            {
                $q->whereIn('agenda_id', Agenda::select('id')->whereIn('space_id', $spaces));
            });
        }

        if($request->input('status') && $request->input('status') !== 'all')
        {
            $bookingsQuery = $bookingsQuery->where('status', $request->input('status'));
        }

        if ($request->user()->rank !== 'admin')
        {
            $bookingsQuery = $bookingsQuery->where('status', 'confirmation');
            $partnerId = $request->user()->selectedPartner()->id;
            $bookingsQuery = $bookingsQuery->whereHas('partners', function ($query) use ($partnerId)
            {
                return $query->where('partner_id', $partnerId);
            });
        }

        return $this->success($bookingsQuery->orderBy('id', 'DESC')->paginate(10));
    }


}
