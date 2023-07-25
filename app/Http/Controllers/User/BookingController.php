<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('user.bookings.index');
    }

    public function show(Booking $booking)
    {
        $this->authorize('accessUserPerspective', $booking);

        return view('user.bookings.show')->with('booking', $booking);
    }

    public function payInvoice(Request $request, Invoice $invoice)
    {
        $request->validate(['paymentMethodId' => 'required']);

        try
        {
            $request->user()->charge($invoice->ttc_total * 100, $request->paymentMethodId);
        } catch (\Throwable $e)
        {
            return redirect()->route('booking.payment-fail');
        }

        $invoice->markAsPaid();

        return redirect()->back();
    }

    public function finalConfirm(Request $request, Booking $booking)
    {
        $this->authorize('accessUserPerspective', $booking);

        $estimate = $booking->estimate;
        $estimate->save();

        $invoice = Invoice::create([
            'booking_id' => $booking->id,
            'address_id' => $booking->estimate->billing_address_id,
            'invoice_id' => 'FC-' . $estimate->id . '-' . now(),
            'type' => 'customer',
            'user_id' => $estimate->user_id,
            'ttc_total' => 0.00,
        ]);

        $ttc_total = 0.00;
        foreach ($estimate->lines as $line)
        {
            $line->quantity = $request->input('quantityFor')[$line->id];

            $price = $line->quantity * $line->unit_price - $line->amount_paid;
            InvoiceLine::create([
                'invoice_id' => $invoice->id,
                'text' => 'Restant pour ' . $line->description,
                'quantity' => $line->quantity - ($line->amount_paid / $line->unit_price),
                'tax_rate' => 20.00,
                'unit_price' => $line->unit_price,
                'total_price' => $price,
                'partner_id' => $line->partner_id,
            ]);
            $line->amount_paid = $line->quantity * $line->unit_price;
            $ttc_total += $price;
            $line->save();
        }
        $invoice->ttc_total = $ttc_total;
        $invoice->save();

        $booking->amount_total = $estimate->lines()->sum('amount_paid');
        $booking->amount_invoiced += $ttc_total;
        $booking->save();

        $invoice = $invoice->fresh();

        $invoice->generatePdf();

        return redirect()->back();
    }

    public function redirectToPay(Request $request, Invoice $invoice)
    {
        return redirect($invoice->getPayUrl());
    }

}
