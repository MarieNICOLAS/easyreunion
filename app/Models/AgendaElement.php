<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaElement extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['start', 'end', 'agenda_id', 'status', 'estimate_id', 'booking_id', 'name', 'estimate_request_id'];

    protected $casts = [
        'start' => 'datetime:d/m/Y à H:i',
        'end' => 'datetime:d/m/Y à H:i',
        'created_at' => 'datetime:d/m/y à H:i',
        'updated_at' => 'datetime:d/m/y à H:i'
    ];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function getSpaceAttribute()
    {
        return $this->agenda->space;
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }

    public function request()
    {
        return $this->belongsTo(EstimateRequest::class, 'estimate_request_id');
    }

    public function getHasConflictsAttribute()
    {
        $start = $this->start;
        $end = $this->end;
        // This returns whether there are confirmation on that date that aren't this
        return AgendaElement::where('id', '!=', $this->id)
                ->whereIn('status', ['confirmation', 'partner_confirmation'])
                ->where('agenda_id', $this->agenda_id)
                ->where(function ($query) use ($start, $end)
                {
                    $query->where(function ($query) use ($start, $end)
                    {
                        $query->where('start', '<=', $start)
                            ->where('end', '>=', $start);
                    });
                    $query->orWhere(function ($query) use ($start, $end)
                    {
                        $query->where('start', '>=', $start)
                            ->where('start', '<=', $end);
                    });
                })
                ->count() > 0;
    }

    public function getDateAttribute()
    {
        return $this->start->format('y-m-d');
    }

    public function getCancellationReasonAttribute()
    {
        if ($this->status !== 'cancelled')
        {
            return $this->booking?->cancellation_reason;
        }
        return '';
    }
}
