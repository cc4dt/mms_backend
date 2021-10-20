<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\NotifyNormalTicketDeadline;
use App\Console\Commands\NotifyEmergencyTicketDeadline;
use App\Console\Commands\NotifyUrgentTicketDeadline;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        NotifyNormalTicketDeadline::class,
        NotifyEmergencyTicketDeadline::class,
        NotifyUrgentTicketDeadline::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('ticket:normal')->everySixHours()
            ->unlessBetween('23:00', '6:00');
        $schedule->command('ticket:urgent')->everyThreeHours()
            ->unlessBetween('23:00', '6:00');
        $schedule->command('ticket:emergency')->hourly()
            ->unlessBetween('23:00', '6:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
