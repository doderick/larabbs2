<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CalculateActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabbs2:calculate-active-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'calculate and cache active users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user)
    {
        // 在命令行打印一条信息
        $this->info('开始计算...');
        // 计算并缓存活跃用户
        $user->calculateAndCacheActiveUsers();
        // 完成之后再打印信息
        $this->info('成功生成！');
    }
}
