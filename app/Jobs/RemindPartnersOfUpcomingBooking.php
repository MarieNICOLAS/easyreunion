<?php

namespace App\Jobs;

use App\Mail\UpcomingEventStartMail;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RemindPartnersOfUpcomingBooking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get all the events that occur tomorrow
        $bookings = Booking::whereDate('starts_at', '>=', Carbon::now()->addDay()->startOfDay())
            ->whereDate('starts_at', '<=', Carbon::now()->addDay()->endOfDay())->with('partners')->get();

        foreach ($bookings as $booking) {
            foreach ($booking->partners as $partner) {
                Mail::to($partner->routeNotificationFor('mail'))->send(new UpcomingEventStartMail($booking));
                sleep(2);
            }
        }
    }
}
