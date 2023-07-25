<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\API\APIController;
use App\Models\Booking;
use App\Models\Estimate;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends APIController
{

    public function cancel(Request $request, Booking $booking)
    {
        $request->validate(['cancellation_reason' => 'required|max:150']);

        $booking->cancel();
        $booking->cancellation_reason = $request->input('cancellation_reason');
        $booking->save();

        return $this->success([]);
    }


    public function updateNote(Request $request, Booking $booking)
    {
        $request->validate(['note' => 'required']);

        $booking->internal_note = $request->input('note');
        $booking->save();

        return $this->success([]);
    }

    public function getAdminList()
    {
        return $this->success(User::select('id', 'first_name', 'last_name')->where('rank', 'admin')->get());
    }

    public function updateReferent(Request $request)
    {
        $request->validate([
            'referent' => 'required|exists:users,id'
        ]);

        if($request->input('estimate_id'))
            Estimate::where('id', $request->input('estimate_id'))->update(['er_referent_id' => $request->input('referent')]);

        if($request->input('booking_id'))
            Booking::where('id', $request->input('booking_id'))->update(['er_referent_id' => $request->input('referent')]);

        return $this->success([]);
    }
}
