<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'partner_id', 'space_id', 'last_verified_at'];

    public function getTypeAttribute()
    {
        return $this->space()->exists() ? 'Agenda d\'une salle' : 'Agenda partenaire';
    }

    public function space()
    {
        return $this->belongsTo(Space::class);
    }


    public function isActive()
    {
        return Carbon::now()->subDays(12)->isBefore($this->last_verified_at);
    }

    public function elements()
    {
        return $this->hasMany(AgendaElement::class)->orderBy('start');
    }

    public function elementsForDay(Carbon $day)
    {
        $elementsThatStart = $this->elements->where('start', '>=', $day->startOfDay())->where('start', '<=', $day->copy()->addDay());
        $elementsMiddle = $this->elements->where('start', '<', $day->startOfDay())->where('end', '>', $day->copy()->addDay());
        $elementsThatEnd = $this->elements->where('end', '>=', $day->startOfDay())->where('end', '<=', $day->copy()->addDay());

        return $elementsThatStart->merge($elementsMiddle)->merge($elementsThatEnd);
    }

    public function computeElements(Carbon $start, $end, $isAdmin = false)
    {

        ini_set('memory_limit', '1024M');
        set_time_limit(0);
        $data = [];

        // Check if is in cache
        $key = 'agenda-' . $this->id . '-' . $start->timestamp . '-' . $end->timestamp . ($isAdmin ? '-admin' : '');

        if (Cache::has($key))
            return Cache::get($key);

        $numDays = $start->diffInDays($end);


        for ($i = 0; $i <= $numDays; $i++)
        {

            $index = $start->format('y-m-d');
            $data[$index] = [];
            $elements = $this->elementsForDay($start);


            // Morning elements
            $start->hour = 12;
            $start->minute = 30;
            $morningElements = $elements->where('start', '<', $start);
            $elementsWithoutRequests = $isAdmin ? $morningElements : $morningElements->filter(function ($e)
            {
                return $e->status !== 'option_request';
            });
            if ($elementsWithoutRequests->count() > 1)
            {
                $data[$index]['am'] = [
                    'status' => $this->getColor($morningElements),
                    'elements ' => $morningElements
                ];
            } else if ($elementsWithoutRequests->count() === 1)
            {
                $data[$index]['am'] = [
                    'elements' => $elementsWithoutRequests,
                    'status' => $elementsWithoutRequests->first()->status
                ];
            } else if ($elementsWithoutRequests->count() === 0 && $morningElements->count() === 1)
            {
                $data[$index]['am'] = [
                    'elements' => $morningElements,
                    'status' => $morningElements->first()->status
                ];
            }
            // Removing elements
            $elements = $elements->where('end', '>', $start);

            // Afternoon elements
            $start->hour = 18;
            $start->minute = 0;
            $afternoonElements = $elements->where('start', '<', $start);
            $elementsWithoutRequests = $isAdmin ? $afternoonElements : $afternoonElements->filter(function ($e)
            {
                return $e->status !== 'option_request';
            });
            if ($elementsWithoutRequests->count() > 1)
            {
                $data[$index]['pm'] = [
                    'status' => $this->getColor($afternoonElements),
                    'elements' => $afternoonElements
                ];
            } else if ($elementsWithoutRequests->count() === 1)
            {
                $data[$index]['pm'] = [
                    'elements' => $elementsWithoutRequests,
                    'status' => $elementsWithoutRequests->first()->status
                ];
            } else if ($elementsWithoutRequests->count() === 0 && $afternoonElements->count() === 1)
            {
                $data[$index]['pm'] = [
                    'elements' => $afternoonElements,
                    'status' => $afternoonElements->first()->status
                ];
            }

            // Evening
            $eveningElements = $elements->where('end', '>', $start);
            $elementsWithoutRequests = $isAdmin ? $eveningElements : $eveningElements->filter(function ($e)
            {
                return $e->status !== 'option_request';
            });
            if ($elementsWithoutRequests->count() > 1)
            {
                $data[$index]['evening'] = [
                    'status' => $this->getColor($eveningElements),
                    'elements ' => $eveningElements
                ];
            } else if ($elementsWithoutRequests->count() === 1)
            {
                $data[$index]['evening'] = [
                    'elements' => $elementsWithoutRequests,
                    'status' => $elementsWithoutRequests->first()->status
                ];
            } else if ($elementsWithoutRequests->count() === 0 && $eveningElements->count() === 1)
            {
                $data[$index]['evening'] = [
                    'elements' => $eveningElements,
                    'status' => $eveningElements->first()->status
                ];
            }

            $start->addDay();
        }

        // Updating list of cache of agenda
        $id = $this->id;

        try
        {
            Cache::lock('cache-agenda-list', 3)->block(30, function () use ($key, $id, $data)
            {
                $list = explode(',', Cache::get('cache-agenda-' . $id, ''));

                if (!in_array($key, $list))
                {
                    $list[] = $key;
                    Cache::put('cache-agenda-' . $id, implode(',', $list));
                }

                Cache::put($key, $data);
            });
        } catch (LockTimeoutException $e)
        {
            Log::error('error acquiring lock');
        }

        return $data;
    }

    private function getColor($agendaElements)
    {
        foreach ($agendaElements as $element)
        {
            if ($element->status === 'confirmation')
                return 'confirmation';

            if ($element->status === 'partner_confirmation')
                return 'partner_confirmation';
        }

        return 'multiple';
    }

    public function flushCache()
    {
        $caches = explode(',', Cache::get('cache-agenda-' . $this->id, ''));

        if (count($caches) === 1 && $caches[0] === '')
        {
            return;
        }
        foreach ($caches as $cache)
        {
            $res = Cache::forget($cache);
            if (!$res)
            {
                \Illuminate\Support\Facades\Log::error('Cache impossible à supprimer');
            }
        }

        Cache::forget('cache-agenda-' . $this->id);
    }


}
