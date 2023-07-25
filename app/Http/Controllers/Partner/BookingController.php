<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('partners.booking.index');
    }

    public function show(Request $request, Booking $booking)
    {
        return view('partners.booking.show')->with(['booking' => $booking]);
    }

}
