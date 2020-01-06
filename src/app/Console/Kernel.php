<?php

namespace App\Console;

use App\Console\Commands\AdminCreateCommand;
use App\Console\Commands\BoratRequirementsCommand;
use App\Console\Commands\EmailUserActivateCommand;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use Laravelista\LumenVendorPublish\VendorPublishCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        VendorPublishCommand::class,
        AdminCreateCommand::class,
        BoratRequirementsCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('borat:requirements')->everyMinute();
    }
}
