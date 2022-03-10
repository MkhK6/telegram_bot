<?php

namespace App\Console;

use App\Commands\SendingCommand;
use Illuminate\Support\Facades\Log;
use App\Http\Services\ParserService;
use App\Http\Services\SendingService;
use App\Http\Services\TelegramService;
use App\Http\Services\SaveCourseService;
use App\Http\Services\SubscriptionService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $service = new SaveCourseService();
            $service->save();
        })->everyTenMinutes();

        $schedule->call(function () {
            $service = new ParserService();
            $service->parser();
        })->twiceDaily(7, 19);
        
        // $schedule->call(function () {
        //     $service = new SendingCommand(TelegramService::getTelegram());
        //     $service->executeMorning();
        // })->dailyAt('8:00');

        // $schedule->call(function () {
        //     $service = new SendingCommand(TelegramService::getTelegram());
        //     $service->executNight();
        // })->dailyAt('20:00');
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
