<?php

namespace App\Http\Controllers;

use App\Events\DepositReceived;
use App\Mail\EstimateSignatureRequestMail;
use App\Models\Estimate;
use App\Models\EstimateElement;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function specifyOffer(Offer $selectedOffer)
    {
        $duration = 0;
        // Compute if duration if forced for this offer
        if ($selectedOffer->start) {
            $duration = Carbon::create($selectedOffer->stop)->diffInHours(Carbon::create($selectedOffer->start));
        }

        return view('booking.specify-offer', ['duration' => $duration])->with('offer', $selectedOffer);
    }

    public function getRecap(Request $request)
    {
        return view('booking.recap')->with('cart', $request->user()->getCurrentCart());
    }

    public function recap(Request $request)
    {
        $request->validate([
            'offer-id' => 'required|int',
            'booking-date' => 'required',
            'booking-time' => 'required',
            'hours-qty' => 'required|int|min:1',
            'quantityFor' => 'required',
        ]);

        // Fetch offer elements and create estimates element from it
        $offer = Offer::where('id', $request->input('offer-id'))->first();
        $cart = $request->user()->getCurrentCart();

        $cart->booking_date = $request->input('booking-date').' '.$request->input('booking-time');
        $cart->qty_hours = $request->input('hours-qty');
        $cart->save();

        // Create all included fields
        if ($offer->included()->get()) {
            foreach ($offer->included()->get() as $included) {
                $qty = $included->unit_type != 'heure' ? $request->input('quantityFor')[$included->id] : $request->input('hours-qty');
                EstimateElement::create([
                    'estimate_id' => $cart->id,
                    'offer_id' => $offer->id,
                    'offer_element_id' => $included->id,
                    'quantity' => $qty,
                ]);
            }
        }

        // Create all optional fields
        if ($request->input('elmts')) {
            foreach ($request->input('elmts') as $elmt => $state) {
                $qty = array_key_exists($elmt, $request->input('quantityFor')) ? $request->input('quantityFor')[$elmt] : $request->input('hours-qty');
                EstimateElement::create([
                    'estimate_id' => $cart->id,
                    'offer_id' => $offer->id,
                    'offer_element_id' => $elmt,
                    'quantity' => $qty,
                ]);
            }
        }

        return view('booking.recap')->with('cart', $cart);
    }

    public function requestSignature(Request $request)
    {
        $request->validate([
            'address_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:12',
        ]);

        $estimate = $request->user()->getCurrentCart();
        $estimate->billing_address_id = $request->input('address_id');
        $estimate->save();

        $url = $estimate->requestSignature($request->input('first_name'), $request->input('last_name'), $request->input('email'), $request->input('phone'));

        Mail::to($request->input('email'))->send(new EstimateSignatureRequestMail($url));

        return redirect()->route('booking.check-signature');
    }

    public function checkSignature(Request $request)
    {
        $estimate = $request->user()->getCurrentCart();

        if ($estimate->signed) {
            return redirect()->route('booking.pay-deposit.index');
        }

        return view('booking.waiting-for-signature');
    }

    public function getPayDeposit()
    {
        return view('booking.pay-deposit');
    }

    public function payDeposit(Request $request)
    {
        $estimate = $request->user()->getCurrentCart();

        $amount = $estimate->calculateDeposit();

        try {
            $payment = $request->user()->charge($amount * 100, $request->paymentMethodId);
        } catch (\Throwable $e) {
            return redirect()->route('booking.payment-fail');
        }
        DepositReceived::dispatch($estimate, $amount);

        return redirect()->route('booking.payment-success');
    }

    public function paymentSuccess()
    {
        return view('booking.payment-success');
    }

    public function paymentFail()
    {
        return view('booking.payment-failed');
    }

    public function discard(Request $request)
    {
        // Discard cart (generate a new Estimate instance)
        Estimate::create([
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('welcome');
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'offer' => 'required|int',
            'date' => 'required',
            'time' => 'required',
            'duration' => 'required',
        ]);
        // Offer
        $offer = Offer::where('id', $request->input('offer'))->first();
        // And now check availability
        $isOk = $offer->checkAvailability($request->input('date'), $request->input('time'), $request->input('duration'));

        return response()->json([
            'status' => $isOk ? 'available' : 'occupied',
        ]);
    }
}
