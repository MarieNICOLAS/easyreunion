<?php

namespace App\Models;

use App\Mail\User\BookingConfirmedMail;
use App\Notifications\BookingConfirmedNotification;
use App\Services\YouSignService;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Mail;

class Estimate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'auto_deposit', 'estimate_request_id', 'internal_note', 'estimate_file', 'organization_id', 'er_referent_id', 'status'];



    public function scopeCart($query)
    {
        return $query->where('status', 'cart');
    }

    public function getIsEmptyAttribute()
    {
        return false;
    }






    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStartsAtAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->booking_date));
    }

    public function getEndsAtAttribute()
    {
        // TODO Add proper timing
        return Carbon::createFromTimeStamp(strtotime($this->booking_date));
    }

    public function billing_address()
    {
        return $this->belongsTo(Address::class);
    }


    public function booking()
    {
        return $this->hasOne(Booking::class);
    }

    public function agendaElements()
    {
        return $this->hasMany(AgendaElement::class);
    }

    public function createBooking()
    {
        if ($this->booking)
            return $this->booking;

        $booking = Booking::create([
            'estimate_id' => $this->id,
            'amount_paid' => 0.00,
            'amount_invoiced' => 0.00,
            'amount_total' => 0.00,
            'ends_at' => $this->ends_at,
            'starts_at' => $this->starts_at,
            'user_id' => $this->user_id,
            'er_referent_id' => $this->er_referent_id,
            'status' => 'confirmation',
            'organization_id' => $this->organization_id
        ]);

        EstimateFile::where('estimate_id', $this->id)->update(['booking_id' => $booking->id]);
        AgendaElement::where('estimate_id', $this->id)->update(['booking_id' => $booking->id, 'status' => 'confirmation']);
        foreach ($this->agendaElements as $el)
            $el->agenda->flushCache();
        $booking->refreshBookingDates();

        // Generate booking partners
        $partners = $this->agendaElements()->with('agenda:id,partner_id')->get()->pluck('agenda')->pluck('partner_id')->toArray();
        foreach (array_unique($partners) as $partnerId)
        {
            BookingPartner::create([
                'booking_id' => $booking->id,
                'partner_id' => $partnerId,
                'status' => 'confirmed'
            ]);
            Partner::find($partnerId)->notify(new BookingConfirmedNotification($booking));
        }
        // Notify user that booked
        Mail::to($booking->user)->send(new BookingConfirmedMail($booking));

        if ($this->auto_deposit)
            $booking->generateInvoice(.5);

        return $booking;
    }

    public function calculateStartDate()
    {
        return $this->agendaElements()->orderBy('start', 'ASC')->first()?->start;
    }

    public function calculateEndDate()
    {
        return $this->agendaElements()->orderBy('end', 'DESC')->first()?->end;
    }

    public function refreshBookingDate()
    {
        $this->booking_date = $this->calculateStartDate();
        $this->save();
    }

    public function getSellsyLinesRepresentation()
    {
        $rows = [];

        foreach ([] as $line)
        {
            $rows[] = [
                'type' => 'single',
                'unit_amount' => strval($line->unit_price),
                'quantity' => strval($line->quantity),
                'description' => $line->description
            ];
        }

        return $rows;
    }

    public function initialRequest()
    {
        return $this->belongsTo(EstimateRequest::class, 'estimate_request_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function files()
    {
        return $this->hasMany(EstimateFile::class);
    }

    public function referent()
    {
        return $this->belongsTo(User::class, 'er_referent_id')->select('id', 'first_name', 'last_name');
    }
}
