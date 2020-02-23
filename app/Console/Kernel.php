<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\Clean::class,
        Commands\ProcessRecurringTransactions::class,
        Commands\Statistic::class,
        Commands\SendFollowUpEmail::class
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command(Commands\Clean::class)->monthly();
        $schedule->command(Commands\SendFollowUpEmail::class)->daily();
        $schedule->command(Commands\ProcessRecurringTransactions::class)->hourly();
    }
}
