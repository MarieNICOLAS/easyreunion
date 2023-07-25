<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateRequest extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'company', 'email', 'phone', 'start', 'end', 'space_id', 'time', 'message', 'status'];

    protected static function booted()
    {
        static::created(function ($request)
        {
            if (!$request->space_id) {
                return;
            }

            // On creation : create associated option requests in agendas
            $agenda = $request->space->agenda;
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);

            $startHour = match ($request->time)
            {
                'day', 'am' => 8,
                'pm' => 13,
                'evening' => 18,
            };
            $startMinute = match ($request->time)
            {
                'day', 'am', 'evening' => 30,
                'pm' => 0,
            };
            $endHour = match ($request->time)
            {
                'day', 'pm' => 18,
                'am' => 12,
                'evening' => 22,
            };
            $endMinute = match ($request->time)
            {
                'day', 'pm' => 0,
                'am', 'evening' => 30,
            };

            $it = $start->diffInDays($end);
            for ($i = 0; $i <= $it; $i++)
            {
                $day = $start->copy()->addDays($i);
                $end = $day->copy();
                $day->hour = $startHour;
                $day->minute = $startMinute;
                $end->hour = $endHour;
                $end->minute = $endMinute;

                AgendaElement::create([
                    'agenda_id' => $agenda->id,
                    'estimate_request_id' => $request->id,
                    'status' => 'option_request',
                    'start' => $day,
                    'end' => $end,
                    'name' => 'Demande de ' . $request->company
                ]);
            }
            $agenda->flushCache();
        });
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    public function agendaElements()
    {
        return $this->hasMany(AgendaElement::class);
    }

    public function closeRequest()
    {
        $this->agendaElements()->delete();
        $this->status = 'closed';
        $this->save();
        $this->space->agenda->flushCache();
    }

    public function estimate()
    {
        return $this->hasOne(Estimate::class, 'estimate_request_id');
    }
}
