<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     * (Optional - Laravel auto-discovers commands, but you can manually register here)
     */
    protected $commands = [
        \App\Console\Commands\FetchTopStories::class,
        \App\Console\Commands\FetchNewStories::class,
        \App\Console\Commands\FetchBestStories::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Stagger the commands to avoid API rate limiting
        $schedule->command('hn:fetch-top')->hourlyAt(5);
        $schedule->command('hn:fetch-new')->hourlyAt(20);
        $schedule->command('hn:fetch-best')->hourlyAt(35);
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