<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Topic;

class SyncTopicViewCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larabbs3:sync-topic-view-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'synchronize topic view count from Redis to DB';

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
    public function handle(Topic $topic)
    {
        $this->info('Start sync...');
        $topic->syncTopicViewCount();
        $this->info('sync successed!');
    }
}
