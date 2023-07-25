<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Estimate;
use App\Models\EstimateActivity;
use App\Models\EstimateElement;
use App\Models\Space;
use App\Services\SellsyService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('admin.bookings.index');
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show')->with('booking', $booking);
    }

    public function getBookingInfo(Booking $booking)
    {
        $booking->append('type_of_problem', 'booking_date');
        $booking->load('files', 'estimate', 'user:id,first_name,last_name,email', 'partners:id,company', 'agendaElements', 'agendaElements.request', 'organization', 'referent');


        $booking->available_spaces = Space::select('id', 'name')->with('agenda:id,space_id,name')->where('space_group_id', $booking->agendaElements->first()?->space?->space_group_id)->get();
        $booking->agendaElements->append('space');
        $data = $booking;
        $data['request'] = $booking->agendaElements->pluck('request')->first();

        return response()->json($data);
    }

    public function addElement(Request $request, Estimate $estimate)
    {
        $request->validate([
            'description' => 'required',
            'unitPrice' => 'required',
            'quantity' => 'required',
            'startsAt' => 'required',
            'endsAt' => 'required',
            'taxRate' => 'required',
        ]);

        $ee = EstimateElement::create([
            'description' => $request->input('description'),
            'booking_id' => $request->input('booking_id'),
            'quantity' => $request->input('quantity'),
            'amount_paid' => 0.00,
            'estimate_id' => $estimate->id,
            'unit_price' => $request->input('unitPrice'),
            'tax_rate' => $request->input('taxRate'),
            'starts_at' => $request->input('startsAt'),
            'ends_at' => $request->input('endsAt')
        ]);

        // Update price
        $estimate->amount_total += $ee->quantity * $ee->unit_price;
        $estimate->save();

        // If there were no updates in the past hour to the estimate, add the info
        if (EstimateActivity::where(['estimate_id' => $estimate->id, 'type' => 'content_update'])->whereDate('created_at', '>=', Carbon::now()->subHour())->count() < 1)
        {
            EstimateActivity::create([
                'user_id' => $request->user()->id,
                'estimate_id' => $estimate->id,
                'text' => 'Devis mis à jour',
                'type' => 'content_update'
            ]);

        }

        // Update on sellsy
        $sellsy = new SellsyService();
        $sellsy->updateEstimate($estimate);

        return response()->json($ee);
    }
}
