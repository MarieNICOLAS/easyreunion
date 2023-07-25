<?php

namespace App\Console\Commands;

use App\Models\BookingPartner;
use App\Models\Problem;
use App\Notifications\Admin\NewProblemsNotification;
use Illuminate\Console\Command;

class CheckPartnersValidations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:check-partners-validation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check partners validations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get all partners that haven't confirmed an event set to take place in less than a week(at least 24h after the booking)
        $problematicBookingPartners = BookingPartner::problematicPartners()->get();

        // If there are problems
        if ($problematicBookingPartners->count() > 0) {
            // Create problem
            foreach ($problematicBookingPartners as $bookingPartner) {
                $bookingPartner->booking->has_problems = true;
                $bookingPartner->booking->save();
            }
        }

        return 0;
    }
}
