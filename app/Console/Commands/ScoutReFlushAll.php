<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScoutReFlushAll extends Command
{

    protected $signature = 'scout:reflush-all';
    protected $description = 'Reflush all searchable models into Laravel Scout';
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('scout:flush', ['model' => 'App\Models\Post']);
        $this->call('scout:flush', ['model' => 'App\Models\Folder']);
        $this->info('All models have been flushed into Scout.');
    }
}
