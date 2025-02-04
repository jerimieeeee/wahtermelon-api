<?php

namespace App\Console;

use App\Jobs\EclaimsStatusJob;
use App\Models\V1\Eclaims\EclaimsUpload;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
       /* $schedule->call(function () {
            // Fetch the claims that need processing
            $claims = EclaimsUpload::where('status', 'pending') // Example condition
            ->get();

            // Dispatch the EclaimsStatusJob for each claim
            foreach ($claims as $claim) {
                EclaimsStatusJob::dispatch($claim);
            }

        })*/
        $schedule->command('eclaims:status')
        ->weeklyOn(7, '00:10') // Every Saturday at 8:00 PM (6 is Saturday, 20:00 is 8:00 PM)
        // ->dailyAt('15:00') // Every day at 8:00 PM
        ->timezone('Asia/Manila'); // Set the timezone to Asia/Manila

        $schedule->command('household:clean')->dailyAt('23:00')->timezone('Asia/Manila');
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
