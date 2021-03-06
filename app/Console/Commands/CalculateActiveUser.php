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
    protected $signature = 'larabbs3:calculate-active-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate active users';

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
        $this->info('Start calculation...');
        $user->calculateAndCacheActiveUsers();
        $this->info('Calculation successed!');
    }
}
