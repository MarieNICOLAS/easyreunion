<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\API\APIController;
use App\Models\Agenda;
use App\Models\Booking;
use App\Models\Estimate;
use App\Models\EstimateRequest;
use App\Models\Space;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StatsController extends APIController
{
    public function generalStats(Request $request)
    {
        $key = 'general-stats';
        if (Cache::has($key))
            return $this->success(Cache::get($key));

        $stats = [];

        $startTwoWeeksAgo = Carbon::now()->subDays(14);
        $endTwoWeeksAgo = Carbon::now()->subDays(7)->subMinute();
        $startLastWeek = Carbon::now()->subDays(7);
        $now = Carbon::now();

        // Number of bookings this week
        $statThisWeek = $this->getNumberOfBookings($startLastWeek, $now);
        $statLastWeek = $this->getNumberOfBookings($startTwoWeeksAgo, $endTwoWeeksAgo);
        $stats[] = [
            'name' => "Nombre de réservations",
            'stat' => $statThisWeek . '',
            'previousStat' => $statLastWeek . '',
            'change' => $statLastWeek > 0 ? round((100 * ($statThisWeek - $statLastWeek) / $statLastWeek)) . '%' : '0%',
            'changeType' => $statThisWeek > $statLastWeek ? 'increase' : 'decrease'
        ];

        // Number of options created this week
        $statThisWeek = $this->getNumberOfOptionsCreated($startLastWeek, $now);
        $statLastWeek = $this->getNumberOfOptionsCreated($startTwoWeeksAgo, $endTwoWeeksAgo);
        $stats[] = [
            'name' => "Nombre d'options créées",
            'stat' => $statThisWeek . '',
            'previousStat' => $statLastWeek . '',
            'change' => $statLastWeek > 0 ? round((100 * ($statThisWeek - $statLastWeek) / $statLastWeek)) . '%' : '0%',
            'changeType' => $statThisWeek > $statLastWeek ? 'increase' : 'decrease'
        ];

        // Number of requests this week
        $statThisWeek = $this->getNumberOfRequests($startLastWeek, $now);
        $statLastWeek = $this->getNumberOfRequests($startTwoWeeksAgo, $endTwoWeeksAgo);
        $stats[] = [
            'name' => "Nombre de demandes",
            'stat' => $statThisWeek . '',
            'previousStat' => $statLastWeek . '',
            'change' => $statLastWeek > 0 ? round((100 * ($statThisWeek - $statLastWeek) / $statLastWeek)) . '%' : '0%',
            'changeType' => $statThisWeek > $statLastWeek ? 'increase' : 'decrease'
        ];

        Cache::put($key, $stats, 21600); // 6 hours
        return $this->success($stats);
    }

    private function getNumberOfBookings($start, $end)
    {
        return Booking::where(function ($query) use ($start, $end)
        {
            $query->where(function ($query) use ($start, $end)
            {
                $query->where('starts_at', '<=', $start)
                    ->where('ends_at', '>=', $start);
            });
            $query->orWhere(function ($query) use ($start, $end)
            {
                $query->where('starts_at', '>=', $start)
                    ->where('starts_at', '<=', $end);
            });
        })
            ->where(['status' => 'confirmation'])
            ->count();
    }

    private function getNumberOfOptionsCreated($start, $end)
    {
        return Estimate::where('created_at', '<=', $end)->where('created_at', '>=', $start)->count();
    }

    private function getNumberOfRequests($start, $end)
    {
        return EstimateRequest::where('created_at', '<=', $end)->where('created_at', '>=', $start)->count();
    }

    public function spaceStats(Request $request)
    {
        $key = 'space-stats';
        if (Cache::has($key))
            return $this->success(Cache::get($key));

        $stats = [];

        foreach (Space::with('agenda')->get() as $space)
        {
            $agenda = $space->agenda;
            $numDaysFilledLastMonth = $this->getNumDaysFilled($agenda, Carbon::now()->subMonth(), Carbon::now());
            $numDaysFilledLastYearSameTime = $this->getNumDaysFilled($agenda, Carbon::now()->subYear()->subMonth(), Carbon::now()->subYear());

            $numDays = Carbon::now()->subMonth()->diffInDays(Carbon::now());

            if ($numDaysFilledLastMonth < 1)
                continue;

            $stats[] = [
                'name' => $space->name,
                'filled' => round(100 * $numDaysFilledLastMonth / $numDays, 2) . '%',
                'filled_last_year' => round(100 * $numDaysFilledLastYearSameTime / $numDays, 2) . '%'
            ];
        }

        Cache::put($key, $stats, 86400); // 24 hours

        return $this->success($stats);
    }

    private function getNumDaysFilled(Agenda $agenda, $start, $end)
    {
        $numDays = 0;
        $elements = $agenda->elements()->where(function ($query) use ($start, $end)
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
        })->where('status', 'confirmation')->get();

        $period = CarbonPeriod::create($start, $end);

        foreach ($period as $date)
        {
            $startOfDay = Carbon::parse($date)->startOfDay();
            $endOfDay = Carbon::parse($date)->endOfDay();

            $elsThatEnd = $elements->where('start', '<=', $startOfDay)->where('end', '>=', $startOfDay)->count();
            $elsThatStart = $elements->where('start', '>=', $startOfDay)->where('start', '<=', $endOfDay)->count();

            if ($elsThatEnd + $elsThatStart > 0)
            {
                $numDays++;
            }
        }

        return $numDays;
    }
}
