<?php

namespace App\Console\Commands;

use App\Models\Agenda;
use Illuminate\Console\Command;

class EmptyCalendarCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:empty-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removing calendar cache';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (Agenda::all() as $agenda)
        {
            $agenda->flushCache();
        }
    }
}
