<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\ChangeStatus::class,
		\App\Console\Commands\SendMonthlyPostEmail::class,
        \App\Console\Commands\SendInactivePostEmail::class,
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
		$schedule->command('email:monthly-posts')->monthly();
        $schedule->command('email:inactive-posts')->weekly();
        $schedule->command('status:change')->daily();
		 $schedule->command('notify:inactive-ads')->weekly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
