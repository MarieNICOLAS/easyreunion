<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingPartner extends Model
{
    use HasFactory;

    protected $fillable = ['booking_id', 'partner_id', 'status'];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function scopeUpcomingWithinWeek($query)
    {
        return $query->whereHas('booking', function ($q)
        {
            $q->whereDate('starts_at', '<=', Carbon::now()->addWeek());
        });
    }

    public function scopeUnconfirmed($query)
    {
        return $query->where('status', 'unconfirmed');
    }

    public function scopeProblematicPartners($query)
    {
        // Defined as partners that haven't confirmed an event set to take place in less than a week(at least 24h after the booking)
        return $query->upcomingWithinWeek()->whereDate('created_at', '<', Carbon::now()->subDay())->unconfirmed();
    }
}
