<?php

namespace App\Models;

use App\Mail\InvoiceMail;
use App\Mail\User\BookingCancelledMail;
use App\Notifications\RegistrationCancelledNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Mail;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'estimate_id', 'status', 'amount_paid', 'amount_invoiced', 'amount_total',
        'starts_at', 'ends_at', 'has_problems', 'internal_note', 'organization_id', 'er_referent_id'];

    protected $casts = [
        'starts_at' => 'datetime:d/m/Y H:i',
        'ends_at' => 'datetime:d/m/Y H:i',
        'created_at' => 'datetime:d/m/Y H:i',
    ];

    public function estimate(): BelongsTo
    {
        return $this->belongsTo(Estimate::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'booking_partners')->withPivot('status');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function scopeFuture($query)
    {
        return $query->whereDate('starts_at', '>=', Carbon::now());
    }

    public function scopePast($query)
    {
        return $query->whereDate('starts_at', '<', Carbon::now());
    }

    public function scopeProblematic($query)
    {
        return $query->where('has_problems', true);
    }

    public function getTypeOfProblemAttribute()
    {
        $problems = [];

        if ($this->partners()->wherePivotNotIn('status', ['confirmed']))
        {
            array_push($problems, 'Partenaires non disponibles ou confirmé');
        }

        if ($this->starts_at < Carbon::now()->addDays(3) && $this->amount_paid < $this->amount_total)
        {
            array_push($problems, 'Paiement manquant');
        }

        return implode(', ', $problems);
    }

    public function lines()
    {
        return $this->hasMany(EstimateElement::class);
    }

    public function agendaElements()
    {
        return $this->hasMany(AgendaElement::class);
    }

    public function getSpacesAttribute()
    {
        $spaces = $this->agendaElements()->with('agenda:id,space_id')->get()->pluck('agenda')->pluck('space_id');
        return Space::select('id', 'name')->whereIn('id', $spaces)->get();
    }

    public function refreshBookingDates()
    {
        $this->starts_at = $this->calculateStartDate();
        $this->ends_at = $this->calculateEndDate();
        $this->save();
    }

    public function calculateStartDate()
    {
        return $this->agendaElements()->orderBy('start', 'ASC')->first()?->start;
    }

    public function calculateEndDate()
    {
        return $this->agendaElements()->orderBy('end', 'DESC')->first()?->end;
    }

    public function generateInvoice(float $partOfTotal)
    {
        $estimate = $this->estimate;
        $invoice = Invoice::create([
            'invoice_id' => 'FC-' . $estimate->id . '-' . now(),
            'type' => 'customer',
            'address_id' => $estimate->billing_address_id,
            'user_id' => $estimate->user_id,
            'ttc_total' => $estimate->totalCost() * $partOfTotal,
            'booking_id' => $this->id
        ]);

        foreach ($estimate->lines as $line)
        {
            $price = $line->quantity * $line->unit_price * (1 + ($line->tax_rate / 100)) * $partOfTotal;

            InvoiceLine::create([
                'invoice_id' => $invoice->id,
                'text' => ($partOfTotal < 1 ? 'Acompte de ' . (int)($partOfTotal * 100) . '% pour ' : '') . $line->description,
                'quantity' => $line->quantity,
                'tax_rate' => $line->tax_rate,
                'unit_price' => $line->unit_price * $partOfTotal,
                'total_price' => $price,
                'partner_id' => $line->partner_id,
            ]);
            $line->amount_paid = $price;
            $line->save();
        }
        $invoice = $invoice->fresh();

        $invoice->generatePdf();

        Mail::to($estimate->user)->send(new InvoiceMail($invoice));
    }

    public function cancel()
    {
        $this->status = 'cancelled';
        $this->save();

        $this->agendaElements()->update(['status' => 'cancelled']);

        foreach ($this->partners as $partner)
            $partner->notify(new RegistrationCancelledNotification($this));

        Mail::to($this->user)->send(new BookingCancelledMail($this));

    }

    public function customerCompanyName()
    {
        return $this->user->organization?->name ?? $this->user->name;
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function getBookingDateAttribute()
    {
        return $this->starts_at->format('d/m/y');
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
