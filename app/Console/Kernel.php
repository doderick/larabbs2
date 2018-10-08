<?php

namespace App\Console;

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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        // 生成活跃用户数据，一小时一次
        $schedule->command('larabbs3:calculate-active-user')
                ->hourly();
        // 从 Redis 中同步 Topic 的浏览计数到数据库中，一小时一次
        $schedule->command('larabbs3:sync-topic-view-count')
                ->hourly();
        // 从 Redis 中同步用户最后登录时间数据至数据库中，每日零时执行一次
        $schedule->command('larabbs3:sync-user-actived-at')
                ->dailyAt('00:00');

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
