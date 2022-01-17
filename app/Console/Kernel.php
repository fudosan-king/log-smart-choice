<?php

namespace App\Console;

use App\Jobs\SendAnnoucement;
use App\Jobs\SendEmailAnnouncement;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\ImportEstatesFromFDK',
        'App\Console\Commands\UpdateTransportStation',
        'App\Console\Commands\UpdateDistrict'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('estates:import_from_fdk')->everyTenMinutes();
        // $schedule->command('estates:estates:update_district')->everyTwoMinutes();
        // $schedule->command('estates:update_transport_station')->everyTwoMinutes();
        // $schedule->job(new SendEmailAnnouncement)->everyTwoMinutes();
        // $schedule->job(new SendAnnoucement)->dailyAt('2:00');
        // $schedule->job(new SendAnnoucement)->dailyAt('8:00');
        // $schedule->job(new SendEmailAnnouncement)->dailyAt('10:00');
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
